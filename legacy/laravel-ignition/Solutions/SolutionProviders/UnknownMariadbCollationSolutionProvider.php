<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Database\QueryException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestUsingMariadbDatabaseSolution;
use Throwable;

class UnknownMariadbCollationSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UnknownMariadbCollationSolutionProvider
{

}
