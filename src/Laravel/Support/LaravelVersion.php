<?php

namespace Spatie\ErrorSolutions\Laravel\Support;

class LaravelVersion
{
    public static function major(): string
    {
        return explode('.', app()->version())[0];
    }
}
