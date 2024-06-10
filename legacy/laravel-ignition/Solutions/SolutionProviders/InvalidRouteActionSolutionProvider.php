<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Support\Str;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Support\Composer\ComposerClassMap;
use Spatie\ErrorSolutions\Laravel\Support\StringComparator;
use Throwable;
use UnexpectedValueException;

class InvalidRouteActionSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\InvalidRouteActionSolutionProvider
{

}
