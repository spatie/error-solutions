<?php

namespace Spatie\ErrorSolutions;

use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Contracts\ProvidesSolution;
use Spatie\ErrorSolutions\Contracts\Solution;
use Spatie\ErrorSolutions\Contracts\SolutionProviderRepository as SolutionProviderRepositoryContract;
use Throwable;

class SolutionProviderRepository implements SolutionProviderRepositoryContract
{
    /** @var array<int, class-string<HasSolutionsForThrowable>|HasSolutionsForThrowable> */
    protected array $solutionProviders;

    /** @param array<int, class-string<HasSolutionsForThrowable>|HasSolutionsForThrowable> $solutionProviders */
    public function __construct(array $solutionProviders = [])
    {
        $this->solutionProviders = $solutionProviders;
    }

    public function registerSolutionProvider(string|HasSolutionsForThrowable $solutionProvider): SolutionProviderRepositoryContract
    {
        $this->solutionProviders[] = $solutionProvider;

        return $this;
    }

    public function registerSolutionProviders(array $solutionProviders): SolutionProviderRepositoryContract
    {
        $this->solutionProviders = array_merge($this->solutionProviders, $solutionProviders);

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

        $providedSolutions = [];

        foreach ($this->initialiseSolutionProviderRepositories() as $solutionProvider) {
            try {
                $solvable = $solutionProvider->canSolve($throwable);

                if (! $solvable) {
                    continue;
                }

                array_push($providedSolutions, ...$solutionProvider->getSolutions($throwable));
            } catch (Throwable $exception) {
                continue;
            }
        }

        return [
            ...$solutions,
            ...$providedSolutions,
        ];
    }

    public function getSolutionForClass(string $solutionClass): ?Solution
    {
        if (! class_exists($solutionClass)) {
            return null;
        }

        if (! in_array(Solution::class, class_implements($solutionClass) ?: [])) {
            return null;
        }

        if (! function_exists('app')) {
            return null;
        }

        return app($solutionClass);
    }

    /** @return array<int, HasSolutionsForThrowable> */
    protected function initialiseSolutionProviderRepositories(): array
    {
        $solutionProviders = array_filter(
            $this->solutionProviders,
            function (HasSolutionsForThrowable|string $provider) {
                if (! in_array(HasSolutionsForThrowable::class, class_implements($provider) ?: [])) {
                    return false;
                }

                if (function_exists('config') && in_array($provider, config('error_solutions.ignored_solution_providers', []))) {
                    return false;
                }

                return true;
            }
        );

        return array_map(
            fn (string|HasSolutionsForThrowable $provider) => is_string($provider) ? new $provider : $provider,
            $solutionProviders
        );
    }
}
