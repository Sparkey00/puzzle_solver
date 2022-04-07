<?php

namespace App\Interfaces;

interface Validator
{
    /**
     * Performs validation
     */
    function validatePuzzle(): void;

    /**
     * Returns validation results
     */
    function isValid(): bool;

    /**
     * Returns array of validation errors
     *
     * @return array
     */
    function getErrors(): array;
}
