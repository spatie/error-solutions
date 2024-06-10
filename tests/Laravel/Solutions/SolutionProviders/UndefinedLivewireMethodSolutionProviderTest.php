<?php

use Livewire\Exceptions\MethodNotFoundException;
use Spatie\ErrorSolutions\Tests\Laravel\stubs\Components\TestLivewireComponent;
use Spatie\ErrorSolutions\Tests\Laravel\TestClasses\FakeLivewireManager;
use Spatie\LaravelIgnition\Solutions\SolutionProviders\UndefinedLivewireMethodSolutionProvider;

it('can solve an unknown livewire method', function () {
    FakeLivewireManager::setUp()->addAlias('test-livewire-component', TestLivewireComponent::class);

    $exception = new MethodNotFoundException('chnge', 'test-livewire-component');

    $canSolve = app(UndefinedLivewireMethodSolutionProvider::class)->canSolve($exception);
    [$solution] = app(UndefinedLivewireMethodSolutionProvider::class)->getSolutions($exception);

    expect($canSolve)->toBeTrue();

    expect($solution->getSolutionTitle())->toBe('Possible typo `Spatie\LaravelIgnition\Tests\stubs\Components\TestLivewireComponent::chnge`');
    expect($solution->getSolutionDescription())->toBe('Did you mean `Spatie\LaravelIgnition\Tests\stubs\Components\TestLivewireComponent::change`?');
})->skip(LIVEWIRE_VERSION_3, 'Missing Livewire 3 support.');
