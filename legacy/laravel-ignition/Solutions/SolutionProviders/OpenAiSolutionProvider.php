<?php

namespace Spatie\LaravelIgnition\Solutions\SolutionProviders;

use Illuminate\Support\Str;
use OpenAI\Client;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\ErrorSolutions\Solutions\OpenAi\OpenAiSolutionProvider as BaseOpenAiSolutionProvider;
use Throwable;

class OpenAiSolutionProvider extends \Spatie\ErrorSolutions\Laravel\Solutions\SolutionProviders\OpenAiSolutionProvider
{

}
