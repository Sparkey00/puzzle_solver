<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/sudoku/upload', [\App\Http\Controllers\SudokuController::class, 'upload']);
Route::get('/sudoku/solve', [\App\Http\Controllers\SudokuController::class, 'solve']);
