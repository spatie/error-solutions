<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Contracts\Solution;
use Spatie\LaravelIgnition\Exceptions\ViewException as IgnitionViewException;
use Spatie\LaravelFlare\Exceptions\ViewException as FlareViewException;
use Spatie\ErrorSolutions\Laravel\Solutions\MakeViewVariableOptionalSolution;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestCorrectVariableNameSolution;
use Throwable;

class UndefinedViewVariableSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UndefinedViewVariableSolutionProvider
{

}
