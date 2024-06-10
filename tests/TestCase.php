<?php

namespace Spatie\ErrorSolutions\Tests;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use Spatie\FlareClient\Glows\Glow;
use Spatie\FlareClient\Report;
use Spatie\LaravelIgnition\Facades\Flare;
use Spatie\LaravelIgnition\IgnitionServiceProvider;
use Spatie\LaravelIgnition\Tests\TestClasses\FakeTime;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use function Spatie\LaravelIgnition\Tests\config;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MakesHttpRequests;


}
