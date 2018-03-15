<?php

namespace Bantenprov\Zona\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Zona facade.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ZonaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'zona';
    }
}
