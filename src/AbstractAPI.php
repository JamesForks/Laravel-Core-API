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
use GrahamCampbell\CoreAPI\Exceptions\ProviderResolutionException;

/**
 * This is the abstract api class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
abstract class AbstractAPI
{
    /**
     * The provider cache.
     *
     * @var array
     */
    protected $provders = array();

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
     * @param  string  $name
     * @return \GrahamCampbell\CoreAPI\Providers\AbstractProvider
     */
    protected function getProvider($name)
    {
        if (!$this->providers[$name]) {
            $this->providers[$name] = $this->getNewProvider($name);
        }

        return $this->providers[$name];
    }

    /**
     * Get a new provider object.
     *
     * @param  string  $name
     * @return \GrahamCampbell\CoreAPI\Providers\AbstractProvider
     */
    protected function getNewProvider($name)
    {
        $class = $this->getProviderClass($name);

        return new $class($this->client);
    }

    /**
     * Get a provider class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getProviderClass($name)
    {
        $class = $this->getProviderNamespace().'\\'.ucfirst($name).'Provider';

        if (class_exists($class)) {
            return $class;
        }

        throw new ProviderResolutionException("Class '$class' not found for the '$name' provider.");
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
     * Dynamically pass information between the providers.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // normalise the method
        if ($where = (strpos($method, 'Where') > 0)) {
            // strip there where from the end
            $normalised = substr($method, 0, -5);
        } else {
            // already normalised
            $normalised = $method;
        }

        // Here we calculate the correct method to call on the provider. Note
        // that this won't work if the singular form is the same as the plural.
        // For this reason, provider classes should be named in away that
        // avoids using such words, otherwise we have no way for the user to
        // specify whether they want a single model, or a collection unless we
        // were to change the syntax of the whole process which is undesirable.
        if (($isSingular = (($singular = str_singular($normalised)) == $normalised)) && !$where) {
            // the normalised method is singular and is not suffixed by "Where"
            $function = 'get';
        } elseif (!$isSingular && !$where) {
            // the normalised method is plural and is not suffixed by "Where"
            $function = 'all';
        } elseif (!$isSingular && $where) {
            // the normalised method is plural and is suffixed by "Where"
            $function = 'where';
        } else {
            // other - the normalised method is probably singular and is suffixed by "Where"
            throw new ProviderResolutionException("The method '$method' could not be resolved.");
        }

        // verify the calculated method actually exists on the provider
        if (!method_exists($provider = $this->getProvider($singular), $function)) {
            throw new ProviderResolutionException("The provider does not support '$function' functionality.");
        }

        // call the underline provider
        return call_user_func_array(array($provider, $function), $parameters);
    }
}
