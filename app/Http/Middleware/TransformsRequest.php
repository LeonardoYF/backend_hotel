<?php

declare(strict_types=1);

namespace App\Http\Middleware;

class TransformsRequest extends \Illuminate\Foundation\Http\Middleware\TransformsRequest
{
    /** @inheritDoc */
    protected function transform($key, $value)
    {
        return is_string($value) ? htmlentities($value, ENT_QUOTES, "UTF-8") : $value;
    }
}