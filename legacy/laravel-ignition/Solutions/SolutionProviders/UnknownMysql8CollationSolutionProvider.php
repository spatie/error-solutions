<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Database\QueryException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestUsingMysql8DatabaseSolution;
use Throwable;

class UnknownMysql8CollationSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UnknownMysql8CollationSolutionProvider
{

}
