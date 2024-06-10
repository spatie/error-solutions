<?php

namespace Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders;

use Illuminate\Support\Collection;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Contracts\ProvidesSolution;
use Spatie\ErrorSolutions\Contracts\Solution;
use Spatie\ErrorSolutions\Contracts\SolutionProviderRepository as SolutionProviderRepositoryContract;
use Throwable;

class SolutionProviderRepository implements SolutionProviderRepositoryContract
{
    /**
     * @var Collection<int, ProvidesSolution> $solutionProviders
     */
    protected Collection $solutionProviders;

    /**
     * @param array<int, ProvidesSolution> $solutionProviders
     */
    public function __construct(array $solutionProviders = [])
    {
        $this->solutionProviders = Collection::make($solutionProviders);
    }

    public function registerSolutionProvider(string $solutionProviderClass): SolutionProviderRepositoryContract
    {
        $this->solutionProviders->push($solutionProviderClass);

        return $this;
    }

    public function registerSolutionProviders(array $solutionProviderClasses): SolutionProviderRepositoryContract
    {
        $this->solutionProviders = $this->solutionProviders->merge($solutionProviderClasses);

        return $this;
    }

    public function getSolutionsForThrowable(Throwable $throwable): array
    {
        $solutions = [];

        if ($throwable instanceof Solution) {
            $solutions[] = $throwable;
        }

        if ($throwable instanceof ProvidesSolution) {
            $solutions[] = $throwable->getSolution();
        }

        $providedSolutions = $this->solutionProviders
            ->filter(function (string $solutionClass) {
                if (! in_array(HasSolutionsForThrowable::class, class_implements($solutionClass) ?: [])) {
                    return false;
                }

                if (in_array($solutionClass, config('ErrorSolutions.ignored_solution_providers', []))) {
                    return false;
                }

                return true;
            })
            ->map(fn (string $solutionClass) => app($solutionClass))
            ->filter(function (HasSolutionsForThrowable $solutionProvider) use ($throwable) {
                try {
                    return $solutionProvider->canSolve($throwable);
                } catch (Throwable $e) {
                    return false;
                }
            })
            ->map(function (HasSolutionsForThrowable $solutionProvider) use ($throwable) {
                try {
                    return $solutionProvider->getSolutions($throwable);
                } catch (Throwable $e) {
                    return [];
                }
            })
            ->flatten()
            ->toArray();

        return array_merge($solutions, $providedSolutions);
    }

    public function getSolutionForClass(string $solutionClass): ?Solution
    {
        if (! class_exists($solutionClass)) {
            return null;
        }

        if (! in_array(Solution::class, class_implements($solutionClass) ?: [])) {
            return null;
        }

        return app($solutionClass);
    }
}
