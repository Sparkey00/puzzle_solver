<?php

namespace App\Http\Controllers;

use App\Http\Puzzles\Files\SudokuPuzzle;
use App\Http\Puzzles\Solvers\SudokuSolver;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SudokuController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function upload(Request $request): Response
    {
        try {
            $sudokuFile = new SudokuPuzzle($request->file('file'));
            $sudokuFile->save('sudoku.txt');

            return response('ok');
        } catch (Exception $exception) {
            return response($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function solve(): array
    {
        $solver = (new SudokuSolver('uploads/sudoku.txt'))->solve();

        return [
            'valid' => $solver->isValid(),
            'genuine' => $solver->genuine,
            'solved' => $solver->isSolved(),
            'results' => $solver->getSolvingResults(),
            'original' => $solver->file->getPuzzle()
        ];
    }
}
