<?php

use OpenAI\Client;

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
