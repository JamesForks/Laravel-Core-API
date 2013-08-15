<?php namespace GrahamCampbell\CoreAPI\Facades;

use Illuminate\Support\Facades\Facade;

class CoreAPI extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'coreapi'; }

}
