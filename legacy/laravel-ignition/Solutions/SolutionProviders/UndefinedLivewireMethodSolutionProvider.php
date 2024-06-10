<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Livewire\Exceptions\MethodNotFoundException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestLivewireMethodNameSolution;
use Spatie\ErrorSolutions\Laravel\Support\LivewireComponentParser;
use Throwable;

class UndefinedLivewireMethodSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UndefinedLivewireMethodSolutionProvider
{

}
