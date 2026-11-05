<?php

use Illuminate\Support\Facades\View;
use Spatie\ErrorSolutions\SolutionProviders\MergeConflictSolutionProvider;
use Spatie\ErrorSolutions\Tests\stubs\Laravel\Components\GitConflictController;

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

it('can describe a merge conflict without a source branch', function () {
    $file = tempnam(sys_get_temp_dir(), 'merge-conflict-');
    file_put_contents($file, "<?php\n<<<<<<< HEAD\n=======\n>>>>>>>\n");

    try {
        try {
            require $file;
        } catch (ParseError $exception) {
            $provider = app(MergeConflictSolutionProvider::class);

            expect($provider->canSolve($exception))->toBeTrue()
                ->and($provider->getSolutions($exception)[0]->getSolutionTitle())
                ->toStartWith("Merge conflict from branch 'unknown branch' into ");
        }
    } finally {
        unlink($file);
    }
});
