<?php

use Composer\InstalledVersions;
use Livewire\Exceptions\MethodNotFoundException;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\UndefinedLivewireMethodSolutionProvider;
use Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\TestLivewireComponent;
use Spatie\ErrorSolutions\Tests\TestClasses\Laravel\FakeLivewireManager;

it('handles an unknown livewire method', function () {
    FakeLivewireManager::setUp()->addAlias('test-livewire-component', TestLivewireComponent::class);

    $exception = new MethodNotFoundException('chnge', 'test-livewire-component');

    $canSolve = app(UndefinedLivewireMethodSolutionProvider::class)->canSolve($exception);
    $solutions = app(UndefinedLivewireMethodSolutionProvider::class)->getSolutions($exception);

    expect($canSolve)->toBeTrue();

    if (version_compare(InstalledVersions::getVersion('livewire/livewire'), '3.0.0', '>=')) {
        expect($solutions)->toBe([]);

        return;
    }

    [$solution] = $solutions;

    expect($solution->getSolutionTitle())->toBe('Possible typo `Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\TestLivewireComponent::chnge`');
    expect($solution->getSolutionDescription())->toBe('Did you mean `Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\TestLivewireComponent::change`?');
});
