<?php


use Illuminate\Support\Str;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingMixManifestSolutionProvider;

it('can solve a missing mix manifest exception', function () {
    $canSolve = app(MissingMixManifestSolutionProvider::class)
        ->canSolve(new Exception('Mix manifest not found.'));

    expect($canSolve)->toBeTrue();
});

it('can recommend running npm install and npm run dev', function () {
    $solution = app(MissingMixManifestSolutionProvider::class)
        ->getSolutions(new Exception('Mix manifest not found.'))[0];

    expect(Str::contains($solution->getSolutionDescription(), 'Did you forget to run `npm install && npm run dev`?'))->toBeTrue();
});
