<?php

namespace App\Http\Puzzles\Validators;

use App\Interfaces\Validator;

class SudokuValidator implements Validator
{
    private array $puzzle;
    private array $errors = [];
    private int $minEntriesCount = 17;
    private int $size;

    /**
     * @param array $puzzle
     * @param int $size
     */
    public function __construct(array $puzzle, int $size)
    {
        $this->puzzle = $puzzle;
        $this->size = $size;
    }

    /**
     * Main Method for the validation
     */
    public function validatePuzzle(): void
    {
        $this->validateNonZeroEntries();
        $this->validateRows();
        $this->validateColumns();
        if ($this->isValid()) {
            $this->validateSquares();
        }
    }

    /**
     * Validates that sudoku has minimum of $minEntriesCount of non-zero digits in order to solve it
     */
    private function validateNonZeroEntries()
    {
        $nonZeroEntries = [];
        foreach ($this->puzzle as $row) {
            $rowWithoutZeroes = array_diff($row, [0]);
            $nonZeroEntries = array_merge($nonZeroEntries, $rowWithoutZeroes);
        }

        if (sizeof($nonZeroEntries) < $this->minEntriesCount) {
            $this->errors[] = sprintf(
                'A sudoku must have at least %d digits placed from the beginning.',
                $this->minEntriesCount
            );
        }
    }

    /**
     * Validates rows for size and repetition of same digits
     */
    private function validateRows()
    {
        for ($i = 0; $i < $this->size; $i++) {
            $row = $this->puzzle[$i] ?? [];
            if (sizeof($row) !== $this->size) {
                $this->errors[] = 'Invalid size of row ' . ($i + 1);
                continue;
            }
            $rowWithoutZeroes = array_diff($row, [0]);
            if (array_unique($rowWithoutZeroes) != $rowWithoutZeroes) {
                $this->errors[] = 'There are non-unique values in row ' . ($i + 1);
            }
        }
    }
    /**
     * Validates columns for size and repetition of same digits
     */
    private function validateColumns()
    {
        for ($i = 0; $i < $this->size; $i++) {
            $column = array_column($this->puzzle, $i);
            if (sizeof($column) !== $this->size) {
                $this->errors[] = 'Invalid size of column ' . ($i + 1);
                continue;
            }
            if (array_unique(array_diff($column, [0])) != array_diff($column, [0])) {
                $this->errors[] = 'There are non-unique values in column ' . $i + 1;
            }
        }
    }

    /**
     * Validates that each individual square 3x3 is composed of unique digits.
     * IMPORTANT: Does not validate squares if previous validations failed
     */
    private function validateSquares()
    {
        $squareCount = 1;
        for ($y = 0; $y < $this->size; $y += 3) {
            for ($x = 0; $x < $this->size; $x += 3) {
                $square = $this->getSquare($y, $x);
                if (array_unique(array_diff($square, [0])) != array_diff($square, [0])) {
                    $this->errors[] = 'There are non-unique values in square ' . $squareCount;
                }
                $squareCount++;
            }
        }
    }

    /**
     * Returns an array of values in a square 3x3
     *
     * @param $yStart
     * @param $xStart
     *
     * @return array
     */
    private function getSquare($yStart, $xStart): array
    {
        $square = [];
        for ($y = $yStart; $y < $yStart + 3; $y++) {
            for ($x = $xStart; $x < $xStart + 3; $x++) {
                $square[] = $this->puzzle[$y][$x];
            }
        }
        return $square;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
