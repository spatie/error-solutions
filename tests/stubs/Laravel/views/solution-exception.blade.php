<h1>This is a blade view with a solution</h1>
@php
use Spatie\ErrorSolutions\Tests\TestClasses\ExceptionWithSolution;

$exception ??= new ExceptionWithSolution;

throw $exception;
@endphp

Oops! I threw up an exception.
