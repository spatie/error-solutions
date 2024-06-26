<?php

use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\DiscoverSolutionProviders;

it('can get all solution providers', function () {
    $providers = DiscoverSolutionProviders::for(['php', 'laravel']);

    expect($providers)
        ->not()->toBeEmpty()
        ->toImplement(HasSolutionsForThrowable::class);
});

it('will discover more solution providers for more types', function () {
    $phpProviders = DiscoverSolutionProviders::for(['php']);

    $laravelProviders = DiscoverSolutionProviders::for(['php', 'laravel']);

    expect(count($laravelProviders))->toBeGreaterThan(count($phpProviders));
});
