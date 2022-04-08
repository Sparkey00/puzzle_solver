<?php

namespace Tests\Unit;

use App\Http\Puzzles\Validators\SudokuValidator;
use Tests\TestCase;

class SudokuValidatorTest extends TestCase
{
    public function testValidateUnsolvable()
    {
        $unsolvable = [
            [0, 0, 7, 0, 8, 0, 0, 9, 2],
            [0, 9, 0, 6, 0, 0, 0, 0, 0],
            [0, 0, 5, 0, 0, 0, 0, 0, 4],
            [0, 1, 0, 0, 7, 0, 4, 0, 0],
            [0, 0, 0, 0, 1, 0, 6, 5, 0],
            [0, 3, 0, 0, 0, 0, 0, 0, 0],
            [0, 7, 0, 4, 0, 0, 2, 0, 6],
            [0, 0, 0, 3, 9, 0, 0, 0, 0],
            [4, 0, 0, 0, 5, 0, 0, 0, 9]
        ];

        $validator = new SudokuValidator($unsolvable, 9);

        $validator->validatePuzzle();

        $this->assertEmpty($validator->getErrors());
        $this->assertTrue($validator->isValid());
    }

    public function testValidateEmpty()
    {
        $array = [];

        $validator = new SudokuValidator($array, 9);

        $validator->validatePuzzle();

        $this->assertNotEmpty($validator->getErrors());
        $this->assertFalse($validator->isValid());
        $this->assertTrue(sizeof($validator->getErrors()) == 19);
        $this->assertTrue(
            in_array(
                "A sudoku must have at least 17 digits placed from the beginning.",
                $validator->getErrors()
            )
        );
        $this->assertTrue(
            in_array(
                "Invalid size of row 1",
                $validator->getErrors()
            )
        );
        $this->assertTrue(
            in_array(
                "Invalid size of column 1",
                $validator->getErrors()
            )
        );
    }

    public function testValidateInvalidSquare()
    {
        $array = [
            [0, 0, 7, 0, 8, 0, 0, 9, 2],
            [0, 9, 0, 6, 0, 0, 0, 0, 0],
            [0, 0, 5, 0, 0, 0, 9, 0, 4],
            [0, 1, 0, 0, 7, 0, 4, 0, 0],
            [0, 0, 0, 0, 1, 0, 6, 5, 0],
            [0, 3, 0, 0, 0, 0, 0, 0, 0],
            [0, 7, 0, 4, 0, 0, 2, 0, 6],
            [0, 0, 0, 3, 9, 0, 0, 0, 0],
            [4, 0, 0, 0, 5, 0, 0, 0, 9]
        ];

        $validator = new SudokuValidator($array, 9);

        $validator->validatePuzzle();

        $this->assertNotEmpty($validator->getErrors());
        $this->assertFalse($validator->isValid());
        $this->assertTrue(sizeof($validator->getErrors()) == 1);
        $this->assertTrue(
            in_array(
                "There are non-unique values in square 3",
                $validator->getErrors()
            )
        );
    }

    public function testValidateValid()
    {
        $array = [
            [0, 0, 7, 0, 8, 0, 0, 9, 1],
            [0, 9, 0, 6, 0, 0, 0, 0, 0],
            [0, 0, 5, 0, 0, 0, 0, 0, 4],
            [0, 1, 0, 0, 7, 0, 4, 0, 0],
            [0, 0, 0, 0, 1, 0, 6, 5, 0],
            [0, 3, 0, 0, 0, 0, 0, 0, 0],
            [0, 7, 0, 4, 0, 0, 2, 0, 6],
            [0, 0, 0, 3, 9, 0, 0, 0, 0],
            [4, 0, 0, 0, 2, 0, 0, 0, 9]
        ];

        $validator = new SudokuValidator($array, 9);

        $validator->validatePuzzle();

        $this->assertEmpty($validator->getErrors());
        $this->assertTrue($validator->isValid());
    }
}
