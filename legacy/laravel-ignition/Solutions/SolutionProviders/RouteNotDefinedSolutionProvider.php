<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Support\Facades\Route;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Support\StringComparator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class RouteNotDefinedSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\RouteNotDefinedSolutionProvider
{

}
