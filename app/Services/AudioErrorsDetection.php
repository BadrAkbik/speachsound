<?php

namespace App\Services;

class AudioErrorsDetection
{
    protected $transcribedWords;

    protected $wordsCount;

    public function splitFilterText($transcribedText)
    {
        $filtered = array_filter(explode(' ', $transcribedText));
        $transcribedWords = array_values($filtered);
        $this->transcribedWords = $transcribedWords;
        $this->wordsCount = count($transcribedWords);
    }

    public function compareWords($correctWords, $specifiedLetters = null)
    {
        $mistakes = [];
        $correctCount = 0;
        $correctWords = explode(' ', $correctWords);

        $length = min(count($correctWords), count($this->transcribedWords));
        for ($index = 0; $index < $length; $index++) {
            if (isset($correctWords[$index])) {
                $correctWord = $correctWords[$index];
                if ($this->transcribedWords[$index] === $correctWord) {
                    $correctCount++;
                } else {
                    // Compare words letter by letter
                    if (isset($specifiedLetters)) {
                        $results = $this->compareSpecifiedLetters($this->transcribedWords[$index], $correctWord, $specifiedLetters);
                    } else {
                        $results = $this->compareLetters($this->transcribedWords[$index], $correctWord);
                    }
                    $mistakes[] = [
                        'expected' => $correctWord,
                        'given' => $this->transcribedWords[$index],
                        'letters' => $results,
                    ];
                }
            } else {
                // Word not expected
                $mistakes[] = [
                    'expected' => null,
                    'given' => $this->transcribedWords[$index],
                    'incorrectLetters' => [],
                ];
            }
        }
        $totalWords = count($correctWords);
        // $sumAccuracy = 0;
        // $totalWords = count($results);
        
        // foreach ($results as $result) {
        //     $sumAccuracy += $result['word_accuracy'];
        // }        
        // $averageAccuracy = ($totalWords > 0) ? $sumAccuracy / $totalWords : 0;

        $totalAccuracy = ($totalWords > 0) ? ($correctCount / $totalWords) * 100 : 0;
        return ['result' => $mistakes, 'total_accuracy' => $totalAccuracy];
    }

    protected function compareLetters($transcribedWord, $correctWord)
    {
        $incorrectLetters = [];
        $length = min(mb_strlen($transcribedWord, 'UTF-8'), mb_strlen($correctWord, 'UTF-8'));
        $correctLettersCount = 0;
        for ($i = 0; $i < $length; $i++) {
            $transcribedLetter = mb_substr($transcribedWord, $i, 1, 'UTF-8') ?? '';
            $correctLetter = mb_substr($correctWord, $i, 1, 'UTF-8') ?? '';
            $id[] = [$transcribedLetter, $correctLetter];
            if ($transcribedLetter !== $correctLetter) {
                $incorrectLetters[] = [
                    'position' => $i,
                    'expected' => $correctLetter,
                    'given' => $transcribedLetter,
                ];
            } else {
                $correctLettersCount++;
            }
        }
        $wordAccuracy = (mb_strlen($correctWord, 'UTF-8') > 0) ? ($correctLettersCount / mb_strlen($correctWord, 'UTF-8')) * 100 : 0;
        return ['incorrect_letters' => $incorrectLetters, 'word_accuracy' => $wordAccuracy];
    }

    protected function compareSpecifiedLetters($transcribedWord, $correctWord, $specifiedLetters)
    {
        $length = max(mb_strlen($transcribedWord, 'UTF-8'), mb_strlen($correctWord, 'UTF-8'));
        $correctLettersCount = 0;
        $specifiedLetterIndexes = [];

        foreach ($specifiedLetters as $specifiedLetter) {
            for ($j = 0; $j < $length; $j++) {

                $correctLetter = mb_substr($correctWord, $j, 1, 'UTF-8') ?? '';
                if ($correctLetter === $specifiedLetter) {
                    array_push($specifiedLetterIndexes, $j);
                }
            }
        }

        foreach ($specifiedLetterIndexes as $index) {
            $transcribedLetter = mb_substr($transcribedWord, $index, 1, 'UTF-8') ?? '';
            $correctLetter = mb_substr($correctWord, $index, 1, 'UTF-8') ?? '';
            if ($transcribedLetter !== $correctLetter) {
                $incorrectLetters[] = [
                    'position' => $index,
                    'expected' => $correctLetter,
                    'given' => $transcribedLetter,
                ];
            } else {
                $correctLettersCount++;
            }
        }
        $wordAccuracy = (count($specifiedLetterIndexes) > 0) ? ($correctLettersCount / count($specifiedLetterIndexes)) * 100 : 0;
        return ['incorrect_letters' => $incorrectLetters, 'word_accuracy' => $wordAccuracy];
    }
}
