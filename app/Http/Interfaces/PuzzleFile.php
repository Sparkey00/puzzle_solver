<?php

namespace App\Interfaces;

interface PuzzleFile
{
    /**
     * Loads a puzzle from a file
     *
     * @param string $path
     */
    public function load(string $path): void;

    /**
     * Saves a puzzle to a file
     *
     * @param string $path
     */
    public function save(string $path): void;
}
