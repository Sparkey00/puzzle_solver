<?php

namespace App\Http\Puzzles\Solvers;

use App\Http\Puzzles\Files\SudokuPuzzle;
use App\Http\Puzzles\Validators\SudokuValidator;
use App\Interfaces\Puzzle;

class SudokuSolver implements Puzzle
{
    private int $size = 9;
    /**
     * @var bool
     */
    private bool $solved = false;

    /**
     * @var SudokuPuzzle
     */
    public SudokuPuzzle $file;

    /**
     * @var bool
     */
    public bool $genuine = false;

    /**
     * @var SudokuValidator
     */
    private SudokuValidator $validator;

    /**
     * @var array
     */
    private array $puzzleBuffer = [];
    /**
     * @var array
     */
    private array $puzzleBufferReverse = [];

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->file = new SudokuPuzzle();
        $this->file->load($path);
        $this->validator = new SudokuValidator($this->file->getPuzzle(), $this->size);
        $this->puzzleBuffer = $this->puzzleBufferReverse = $this->file->getPuzzle();

        $this->validator->validatePuzzle();
    }

    /**
     * @inheritDoc
     */
    public function solve(): Puzzle
    {
        if ($this->isValid()) {
            $this->solved = $this->iterate(0, 0);
            $this->iterateReverse(0, 0);
            $this->setIsGenuine();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isSolved(): bool
    {
        return $this->solved;
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->validator->isValid();
    }


    /**
     * @param int $yAxis
     * @param int $xAxis
     * @return bool
     */
    private function iterate(int $yAxis, int $xAxis): bool
    {
        if ($yAxis == $this->size - 1 && $xAxis == $this->size) {
            return true;
        }

        if ($xAxis == $this->size) {
            $yAxis++;
            $xAxis = 0;
        }
        if ($this->puzzleBuffer[$yAxis][$xAxis] != 0) {
            return $this->iterate($yAxis, $xAxis + 1);
        }

        for ($i = 1; $i <= $this->size; $i++) {
            if ($this->isAvailable($yAxis, $xAxis, $i, $this->puzzleBuffer)) {
                $this->puzzleBuffer[$yAxis][$xAxis] = $i;
                if ($this->iterate($yAxis, $xAxis + 1)) {
                    return true;
                }
            }
            $this->puzzleBuffer[$yAxis][$xAxis] = 0;
        }
        return false;
    }

    /**
     * @param int $yAxis
     * @param int $xAxis
     * @return bool
     */
    private function iterateReverse(int $yAxis, int $xAxis): bool
    {
        if ($yAxis == $this->size - 1 && $xAxis == $this->size) {
            return true;
        }

        if ($xAxis == $this->size) {
            $yAxis++;
            $xAxis = 0;
        }
        if ($this->puzzleBufferReverse[$yAxis][$xAxis] != 0) {
            return $this->iterateReverse($yAxis, $xAxis + 1);
        }

        for ($i = $this->size; $i >= 1; $i--) {
            if ($this->isAvailable($yAxis, $xAxis, $i, $this->puzzleBufferReverse)) {
                $this->puzzleBufferReverse[$yAxis][$xAxis] = $i;
                if ($this->iterateReverse($yAxis, $xAxis + 1)) {
                    return true;
                }
            }
            $this->puzzleBufferReverse[$yAxis][$xAxis] = 0;
        }
        return false;
    }


    /**
     * @param int $yAxis
     * @param int $xAxis
     * @param int $number
     * @param array $puzzle
     *
     * @return bool
     */
    private function isAvailable(int $yAxis, int $xAxis, int $number, array $puzzle): bool
    {
        // checking if number is already present in horizontal or vertical line
        for ($i = 0; $i < $this->size; $i++) {
            if (
                $puzzle[$yAxis][$i] == $number
                || $puzzle[$i][$xAxis] == $number
            ) {
                return false;
            }
        }

        //checking inner 3x3 square for number
        $xAxisMin = floor($xAxis / 3) * 3;
        $yAxisMin = floor($yAxis / 3) * 3;

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($puzzle[$yAxisMin + $i][$xAxisMin + $j] == $number) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getSolvingResults(): array
    {
        if ($this->isValid() && $this->isSolved()) {
            return ['forward' => $this->puzzleBuffer, 'reverse' => $this->puzzleBufferReverse];
        } else {
            return $this->validator->getErrors();
        }
    }

    /**
     * @return void
     */
    public function setIsGenuine(): void
    {
        $this->genuine = $this->puzzleBuffer == $this->puzzleBufferReverse;
    }
}
