<?php

namespace Tests\Feature;

use App\Http\Puzzles\Solvers\SudokuSolver;
use Tests\TestCase;

class SudokuPuzzleSolverTest extends TestCase
{
    public function testSolveDefault() {
        $solver = (new SudokuSolver('uploads/test/sudoku_default.txt'))->solve();

        $this->assertTrue($solver->isValid());
        $this->assertTrue($solver->isSolved());
        $this->assertFalse($solver->genuine);

        $result = $solver->getSolvingResults();
        $original = $solver->file->getPuzzle();

        $this->assertIsArray($result);
        $this->assertIsArray($original);
        $this->assertArrayHasKey('forward', $result);
        $this->assertArrayHasKey('reverse', $result);
    }

    public function testSolveCorrupted() {
        $solver = (new SudokuSolver('uploads/test/sudoku_corrupted.txt'))->solve();

        $this->assertFalse($solver->isValid());
        $this->assertFalse($solver->isSolved());
        $this->assertFalse($solver->genuine);

        $result = $solver->getSolvingResults();
        $original = $solver->file->getPuzzle();

        $this->assertIsArray($result);
        $this->assertIsArray($original);
        $this->assertArrayNotHasKey('forward', $result);
        $this->assertArrayNotHasKey('reverse', $result);
    }

    public function testSolveInvalid() {
        $solver = (new SudokuSolver('uploads/test/sudoku_invalid.txt'))->solve();

        $this->assertFalse($solver->isValid());
        $this->assertFalse($solver->isSolved());
        $this->assertFalse($solver->genuine);

        $result = $solver->getSolvingResults();
        $original = $solver->file->getPuzzle();

        $this->assertIsArray($result);
        $this->assertIsArray($original);
        $this->assertArrayNotHasKey('forward', $result);
        $this->assertArrayNotHasKey('reverse', $result);
        $this->assertNotEmpty($result);
    }

    public function testSolveGenuine() {
        $solver = (new SudokuSolver('uploads/test/sudoku_hard.txt'))->solve();

        $this->assertTrue($solver->isValid());
        $this->assertTrue($solver->isSolved());
        $this->assertTrue($solver->genuine);

        $result = $solver->getSolvingResults();
        $original = $solver->file->getPuzzle();

        $this->assertIsArray($result);
        $this->assertIsArray($original);
        $this->assertArrayHasKey('forward', $result);
        $this->assertArrayHasKey('reverse', $result);
        $this->assertSame($result['forward'], $result['reverse']);
    }

    public function testSolveUnsolvable() {
        $solver = (new SudokuSolver('uploads/test/sudoku_unsolvable.txt'))->solve();

        $this->assertTrue($solver->isValid());
        $this->assertFalse($solver->isSolved());
        $this->assertTrue($solver->genuine);

        $result = $solver->getSolvingResults();
        $original = $solver->file->getPuzzle();

        $this->assertIsArray($result);
        $this->assertIsArray($original);
        $this->assertArrayNotHasKey('forward', $result);
        $this->assertArrayNotHasKey('reverse', $result);
    }
}
