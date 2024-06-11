<?php

namespace Spatie\ErrorSolutions\Tests\Exceptions;

use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Throwable;

class AlwaysTrueSolutionProvider implements HasSolutionsForThrowable
{
    public function canSolve(Throwable $throwable): bool
    {
        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        return [new BaseSolution('Base Solution')];
    }
}
