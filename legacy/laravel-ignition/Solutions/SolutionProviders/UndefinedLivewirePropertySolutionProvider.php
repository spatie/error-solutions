<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Livewire\Exceptions\PropertyNotFoundException;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Laravel\Solutions\SuggestLivewirePropertyNameSolution;
use Spatie\ErrorSolutions\Laravel\Support\LivewireComponentParser;
use Throwable;

class UndefinedLivewirePropertySolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\UndefinedLivewirePropertySolutionProvider
{

}
