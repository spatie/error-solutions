<?php

use Dotenv\Dotenv;
use OpenAI\Client;
use Spatie\ErrorSolutions\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

if (file_exists(__DIR__ . '/../.env')) {
    $dotEnv = Dotenv::createImmutable(__DIR__ . '/..');

    $dotEnv->load();
}

function canRunOpenAiTest(): bool
{
    if (empty(env('OPEN_API_KEY'))) {
        return false;
    }

    if (! class_exists(Client::class)) {
        return false;

    }

    return true;
}
