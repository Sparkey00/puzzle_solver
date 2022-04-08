<?php

namespace Tests\Unit;

use App\Http\Puzzles\Files\SudokuPuzzle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SudokuPuzzleTest extends TestCase
{
    public function testSudokuSave()
    {
        $file = new SudokuPuzzle(UploadedFile::fake()->create('sudoku.txt', 1));
        $file->save('test/sudoku.txt');

        Storage::disk('public')->assertExists('uploads/test/sudoku.txt');
    }

    public function testSudokuLoad()
    {
        $file = new SudokuPuzzle();
        $file->load('uploads/test/sudoku_default.txt');

        $this->assertIsArray($file->getPuzzle());
        $this->assertNotEmpty($file->getPuzzle());
    }
}
