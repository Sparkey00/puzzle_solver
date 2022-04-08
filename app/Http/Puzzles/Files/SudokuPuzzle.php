<?php

namespace App\Http\Puzzles\Files;

use App\Interfaces\PuzzleFile;
use Illuminate\Support\Facades\Storage;

class SudokuPuzzle implements PuzzleFile
{
    /**
     * @var array loaded sudoku in a form of array
     */
    private array $puzzle = [];
    /**
     * @var mixed
     */
    private $fileContents;

    public function __construct($puzzle = null)
    {
        $this->fileContents = $puzzle;
    }

    /**
     * @inheritDoc
     */
    public function load(string $path): void
    {
        $filename = Storage::disk('public')->path($path);
        if ($file = fopen($filename, "r")) {
            while (!feof($file)) {
                $line = trim(fgets($file));
                if($line != '') {
                    $this->puzzle[] = array_map(function ($val) {
                        return is_numeric($val) ? (int)$val : 0;
                    }, str_split($line));
                }
            }
            fclose($file);
        }

    }

    /**
     * @inheritDoc
     */
    public function save(string $path): void
    {
        if(str_contains('/', $path)) {
            $exploded = explode('/', $path);
            $fileName = array_pop($exploded);
            $folder = array_pop($exploded);

            $this->fileContents->storeAs($folder, $fileName, 'public');
        } else {
            $this->fileContents->storeAs('uploads', $path, 'public');
        }
    }

    /**
     * @return array
     */
    public function getPuzzle(): array
    {
        return $this->puzzle;
    }
}
