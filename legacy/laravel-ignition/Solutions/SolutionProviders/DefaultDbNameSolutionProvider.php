<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Database\QueryException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestUsingCorrectDbNameSolution;
use Throwable;

class DefaultDbNameSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\DefaultDbNameSolutionProvider
{

}
