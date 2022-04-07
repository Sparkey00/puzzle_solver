<?php

use App\Http\Controllers\SudokuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/sudoku/upload', [SudokuController::class, 'upload']);
Route::get('/sudoku/solve', [SudokuController::class, 'solve']);
