<?php

use Livewire\Exceptions\PropertyNotFoundException;
use Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\TestLivewireComponent;
use Spatie\ErrorSolutions\Tests\TestClasses\Laravel\FakeLivewireManager;
use Spatie\LaravelIgnition\Solutions\SolutionProviders\UndefinedLivewirePropertySolutionProvider;

it('can solve an unknown livewire computed property', function () {
    FakeLivewireManager::setUp()->addAlias('test-livewire-component', TestLivewireComponent::class);

    $exception = new PropertyNotFoundException('compted', 'test-livewire-component');

    $canSolve = app(UndefinedLivewirePropertySolutionProvider::class)->canSolve($exception);
    [$solution] = app(UndefinedLivewirePropertySolutionProvider::class)->getSolutions($exception);

    expect($canSolve)->toBeTrue();

    expect($solution->getSolutionTitle())->toBe('Possible typo $compted');
    expect($solution->getSolutionDescription())->toBe('Did you mean `$computed`?');
});

// Helpers
function it_can_solve_an_unknown_livewire_property()
{
    FakeLivewireManager::setUp()->addAlias('test-livewire-component', TestLivewireComponent::class);

    $exception = new PropertyNotFoundException('strng', 'test-livewire-component');

    $canSolve = app(UndefinedLivewirePropertySolutionProvider::class)->canSolve($exception);
    [$firstSolution, $secondSolution] = app(UndefinedLivewirePropertySolutionProvider::class)->getSolutions($exception);

    expect($canSolve)->toBeTrue();

    expect($firstSolution->getSolutionTitle())->toBe('Possible typo $strng');
    expect($firstSolution->getSolutionDescription())->toBe('Did you mean `$string`?');

    expect($secondSolution->getSolutionTitle())->toBe('Possible typo $strng');
    expect($secondSolution->getSolutionDescription())->toBe('Did you mean `$stringable`?');
}
