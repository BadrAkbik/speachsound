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

        foreach ($this->transcribedWords as $index => $transcribedWord) {
            if (isset($correctWords[$index])) {
                $correctWord = $correctWords[$index];
                if ($transcribedWord === $correctWord) {
                    $correctCount++;
                } else {
                    // Compare words letter by letter
                    if (isset($specifiedLetters)) {
                        $incorrectLetters = $this->compareSpecifiedLetters($transcribedWord, $correctWord, $specifiedLetters);
                    } else {
                        $incorrectLetters = $this->compareLetters($transcribedWord, $correctWord);
                    }
                    $mistakes[] = [
                        'expected' => $correctWord,
                        'given' => $transcribedWord,
                        'letters' => $incorrectLetters,
                    ];
                }
            } else {
                // Word not expected
                $mistakes[] = [
                    'expected' => null,
                    'given' => $transcribedWord,
                    'incorrectLetters' => [],
                ];
            }
        }
        $totalWords = count($correctWords);
        $totalAccuracy = ($totalWords > 0) ? ($correctCount / $totalWords) * 100 : 0;

        return ['mistakes' => $mistakes, 'total_accuracy' => $totalAccuracy];
    }

    protected function compareLetters($transcribedWord, $correctWord)
    {
        $incorrectLetters = [];
        $length = max(strlen($transcribedWord), strlen($correctWord));
        $correctLettersCount = 0;
        for ($i = 0; $i < $length; $i++) {
            $transcribedLetter = mb_substr($transcribedWord, $i, 1, 'UTF-8') ?? '';
            $correctLetter = mb_substr($correctWord, $i, 1, 'UTF-8') ?? '';
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
        $wordAccuracy = (strlen($correctWord) > 0) ? ($correctLettersCount / strlen($correctWord)) * 100 : 0;
        return ['incorrect_letters' => $incorrectLetters, 'word_accuracy' => $wordAccuracy];
    }

    protected function compareSpecifiedLetters($transcribedWord, $correctWord, $specifiedLetters)
    {
        $length = max(strlen($transcribedWord), strlen($correctWord));
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
