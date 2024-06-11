<?php

use Illuminate\Support\Facades\View;
use Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\GitConflictController;
use Spatie\Ignition\Solutions\SolutionProviders\MergeConflictSolutionProvider;

beforeEach(function () {
    View::addLocation(__DIR__.'/../stubs/views');
});

it('can solve merge conflict exception', function () {
    try {
        app(GitConflictController::class);
    } catch (ParseError $error) {
        $exception = $error;
    }
    $canSolve = app(MergeConflictSolutionProvider::class)->canSolve($exception);

    expect($canSolve)->toBeTrue();
});
