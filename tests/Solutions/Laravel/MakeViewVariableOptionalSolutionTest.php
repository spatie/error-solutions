<?php

use Illuminate\Support\Facades\View;
use Spatie\ErrorSolutions\Support\Laravel\Composer\ComposerClassMap;
use Spatie\LaravelIgnition\Solutions\MakeViewVariableOptionalSolution;

beforeEach(function () {
    View::addLocation(__DIR__.'/../stubs/views');

    app()->bind(
        ComposerClassMap::class,
        function () {
            return new ComposerClassMap(__DIR__.'/../../../vendor/autoload.php');
        }
    );
});

it('does not open scheme paths', function () {
    $solution = getSolutionForPath('php://filter/resource=./tests/stubs/Laravel/views/blade-exception.blade.php');
    expect($solution->isRunnable())->toBeFalse();
});

it('does open relative paths', function () {
    $solution = getSolutionForPath('./tests/stubs/Laravel/views/blade-exception.blade.php');
    expect($solution->isRunnable())->toBeTrue();
});

it('does not open other extensions', function () {
    $solution = getSolutionForPath('./tests/stubs/Laravel/views/php-exception.php');
    expect($solution->isRunnable())->toBeFalse();
});

// Helpers
function getSolutionForPath($path): MakeViewVariableOptionalSolution
{
    return new MakeViewVariableOptionalSolution('notSet', $path);
}
