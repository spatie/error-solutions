<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Support\Collection;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Contracts\ProvidesSolution;
use Spatie\ErrorSolutions\Contracts\Solution;
use Spatie\Ignition\Contracts\SolutionProviderRepository as SolutionProviderRepositoryContract;
use Throwable;

class SolutionProviderRepository extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\SolutionProviderRepository implements SolutionProviderRepositoryContract
{

}
