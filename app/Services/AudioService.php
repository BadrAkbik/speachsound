<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Http\Resources\SoundProgressResource;
use App\Models\Sound;
use App\Models\SoundProgress;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AudioService
{
    protected $transcribedWords;

    protected $wordsCount;

    protected $spelledRequiredWord;

    protected $sound;

    protected $records = [];

    public function aiModel($audio)
    {
        return Http::attach(
            'audio',
            file_get_contents($audio),
            $audio->getClientOriginalName()
        )->post(env('AI_MODEL_URL'), [
                    'audio' => $audio
                ]);
    }

    public function handle($data)
    {
        $response = $this->aiModel($data['audio']);

        if (!$response->successful()) {
            throw new GeneralException(__('api.Something_went_wrong'));
        }

        return \DB::transaction(function () use ($data, $response) {
            $transcribedText = json_decode($response)->text;

            $this->sound = Sound::find($data['sound_id']);

            $this->splitFilterText($transcribedText);

            $this->spelledRequiredWord = $this->sound->spelled_word ?? $this->sound->written_word;

            $result = $this->compareWords();

            $success_rate = $this->sound->success_rate ?? 100;
            $attempts_to_success = $this->sound->attempts_to_success ?? 1;
            $success = $result['total_accuracy'] >= $success_rate;

            $this->storeRecord($data['audio'], $success);
            $sound_progress = $this->StoreSoundProgress($success, $attempts_to_success, $result);


            return [
                'result' => $result,
                'sound_progress' => new SoundProgressResource($sound_progress)
            ];
        });

    }

    protected function storeRecord($audio, $success)
    {
        $uniqueName = Str::uuid() . '.' . $audio->getClientOriginalExtension();
        $audioPath = $audio->storeAs('recordings', $uniqueName, 'public');

        $this->records[] = [
            'file_path' => $audioPath,
            'status' => $success ? 'success' : 'failure',
            'date' => now()->toDateTimeString()
        ];
    }

    public function StoreSoundProgress($success, $attempts_to_success, $result)
    {
        $soundProgress = SoundProgress::where('sound_id', $this->sound->id)->where('letter_id', $this->sound->letter->id)->where('trainee_id', auth()->user()->id)->first();
        if (!$soundProgress) {
            $soundProgress = SoundProgress::create([
                'sound_id' => $this->sound->id,
                'letter_id' => $this->sound->letter->id,
                'trainee_id' => auth()->user()->id,
                'success_attempts' => $success ? 1 : 0,
                'failure_attempts' => !$success ? 1 : 0,
                'status' => $attempts_to_success === 1 ? 'completed' : 'in_progress',
                'records' => $this->records,
                'result' => $result
            ]);
        } else {
            $previous_success_attempts = $soundProgress->success_attempts ?? 0;
            $previous_failure_attempts = $soundProgress->failure_attempts ?? 0;
            $soundProgress->success_attempts = $success ? $previous_success_attempts + 1 : $previous_success_attempts;
            $soundProgress->failure_attempts = !$success ? $previous_failure_attempts + 1 : $previous_failure_attempts;
            $soundProgress->status = $attempts_to_success === ($success ? $previous_success_attempts + 1 : $previous_success_attempts) ? 'completed' : 'in_progress';
            $soundProgress->result = $result;
            $soundProgress->records = array_merge($soundProgress->records ?? [], $this->records);
            $soundProgress->save();
        }
        return $soundProgress;
    }


    public function splitFilterText($transcribedText)
    {
        $filtered = array_filter(explode(' ', $transcribedText));
        $transcribedWords = array_values($filtered);
        $this->transcribedWords = $transcribedWords;
        $this->wordsCount = count($transcribedWords);
    }

    public function compareWords()
    {
        $mistakes = [];
        $correctMatches = [];
        $correctCount = 0;
        $correctWords = explode(' ', $this->spelledRequiredWord);
        $length = min(count($correctWords), count($this->transcribedWords));

        for ($index = 0; $index < $length; $index++) {
            if (isset($correctWords[$index])) {
                $correctWord = $correctWords[$index];
                if ($this->transcribedWords[$index] === $correctWord) {
                    $correctCount++;
                    $correctMatches[] = [
                        'word' => $correctWord,
                        'index' => $index
                    ];
                } else {
                    // Compare specific letters in the words
                    $results = $this->compareSpecifiedLetters($this->transcribedWords[$index], $correctWord);

                    $mistakes[] = [
                        'expected' => $correctWord,
                        'given' => $this->transcribedWords[$index],
                        'letters' => $results,
                    ];
                }
            } else {
                // Extra word transcribed that wasn't expected
                $mistakes[] = [
                    'expected' => null,
                    'given' => $this->transcribedWords[$index],
                    'letters' => [
                        'incorrect_letters' => [],
                        'correct_letters' => [],
                        'word_accuracy' => 0
                    ]
                ];
            }
        }
        $totalWords = count($correctWords);
        $totalAccuracy = ($totalWords > 0) ? ($correctCount / $totalWords) * 100 : 0;

        return [
            'mistakes' => $mistakes,
            'correct_words' => $correctMatches,
            'total_accuracy' => $totalAccuracy
        ];
    }
    protected function compareSpecifiedLetters($transcribedWord, $correctWord)
    {
        $incorrectLetters = [];
        $correctLetters = [];
        $correctLettersCount = 0;
        $specifiedLetterIndexes = [];

        // Find positions of the specified letter in the correct word
        for ($j = 0; $j < mb_strlen($correctWord, 'UTF-8'); $j++) {
            $correctLetter = mb_substr($correctWord, $j, 1, 'UTF-8') ?? '';
            if ($correctLetter === $this->sound->letter->letter) {
                array_push($specifiedLetterIndexes, $j);
            }
        }

        // Compare letters at the found positions
        foreach ($specifiedLetterIndexes as $index) {
            // Check if the index exists in the transcribed word
            if ($index < mb_strlen($transcribedWord, 'UTF-8')) {
                $transcribedLetter = mb_substr($transcribedWord, $index, 1, 'UTF-8');
                $correctLetter = mb_substr($correctWord, $index, 1, 'UTF-8');

                if ($transcribedLetter !== $correctLetter) {
                    $incorrectLetters[] = [
                        'position' => $index,
                        'expected' => $correctLetter,
                        'given' => $transcribedLetter,
                    ];
                } else {
                    $correctLettersCount++;
                    $correctLetters[] = [
                        'position' => $index,
                        'letter' => $correctLetter
                    ];
                }
            } else {
                // The transcribed word is shorter than the position where the specified letter exists
                $incorrectLetters[] = [
                    'position' => $index,
                    'expected' => mb_substr($correctWord, $index, 1, 'UTF-8'),
                    'given' => '', // No character at this position
                ];
            }
        }

        // If the words are exactly the same, accuracy is 100%
        if ($transcribedWord === $correctWord) {
            $wordAccuracy = 100;
        } else {
            // If no specified letter in the word but words are different, accuracy is 0%
            if (count($specifiedLetterIndexes) === 0) {
                $wordAccuracy = 0;
            } else {
                // Otherwise calculate based on correct matches of the specified letter
                $wordAccuracy = ($correctLettersCount / count($specifiedLetterIndexes)) * 100;
            }
        }

        return [
            'incorrect_letters' => $incorrectLetters,
            'correct_letters' => $correctLetters,
            'word_accuracy' => $wordAccuracy
        ];
    }

}
