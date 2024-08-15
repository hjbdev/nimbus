<?php

namespace Hjbdev\Nimbus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hjbdev\Nimbus\Nimbus
 */
class Nimbus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hjbdev\Nimbus\Nimbus::class;
    }
}
