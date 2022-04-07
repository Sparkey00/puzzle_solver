<?php

namespace App\Interfaces;

interface Puzzle
{
    /**
     * Returns true if puzzle is solved
     *
     * @return bool
     */
    public function isSolved(): bool;

    /**
     * Returns true if board is valid
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Generates a solution. Does not modify the current puzzle.
     *
     * @return Puzzle
     */
    public function solve(): Puzzle;
}
