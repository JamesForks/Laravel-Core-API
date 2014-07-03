<?php

/**
 * This file is part of Laravel Core API by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\CoreAPI;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * This is the core api class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
abstract AbstractAPI
{
    /**
     * The provider cache.
     *
     * @var array
     */
    protected $provders = array()

    /**
     * The guzzle client class.
     *
     * @var \GuzzleHttp\Command\Guzzle\GuzzleClient
     */
    protected $client;

    /**
     * Create a new core api instance.
     *
     * @param  \GuzzleHttp\Command\Guzzle\GuzzleClient  $client
     * @return void
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get the provider namespace.
     *
     * @return string
     */
    abstract protected function getProviderNamespace();

    /**
     * Get a provider object.
     *
     * @return \GrahamCampbell\CoreAPI\Providers\AbstractProvider
     */
    protected function getProvider($name)
    {
        if (!$this->providers[$name]) {
            $class = $this->getProviderClass($name);
            $this->providers[$name] = new $class($this->client);
        }

        return $this->zones;
    }

    protected function getProviderClass($name)
    {
        return $this->getProviderNamespace().'\\'.ucfirst($name).'Provider';
    }

    /**
     * Get the client instance.
     *
     * @return \GuzzleHttp\Command\Guzzle\GuzzleClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getProvider(str_singular($method));
    }
}
