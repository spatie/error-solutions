<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use BadMethodCallException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use ReflectionClass;
use ReflectionMethod;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Support\StringComparator;
use Throwable;

class UnknownValidationSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UnknownValidationSolutionProvider
{

}
