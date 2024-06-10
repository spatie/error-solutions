<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Database\QueryException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\RunMigrationsSolution;
use Throwable;

class MissingColumnSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\MissingColumnSolutionProvider
{

}
