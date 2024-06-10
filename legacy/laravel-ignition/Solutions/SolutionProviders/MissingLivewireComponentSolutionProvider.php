<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\LivewireComponentsFinder;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\LivewireDiscoverSolution;
use Throwable;

class MissingLivewireComponentSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\MissingLivewireComponentSolutionProvider
{

}
