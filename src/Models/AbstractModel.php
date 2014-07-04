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

namespace GrahamCampbell\CoreAPI\Models;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * This is the abstract model class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
abstract class AbstractModel
{
    /**
     * The guzzle client class.
     *
     * @var \GuzzleHttp\Command\Guzzle\GuzzleClient
     */
    protected $client;

    /**
     * The request cache.
     *
     * @var array
     */
    protected $cache;

    /**
     * Create a new model instance.
     *
     * @param  \GuzzleHttp\Command\Guzzle\GuzzleClient  $client
     * @param  array  $cache
     * @return void
     */
    public function __construct(GuzzleClient $client, array $cache = array())
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * Clear the request cache.
     *
     * @param  array|string  $methods
     * @return void
     */
    public function clearCache($methods = null)
    {
        if ($methods === null || $methods === 'all') {
            $this->cache = array();
        } else {
            foreach ((array) $methods as $method) {
                $this->cache[$method] = array();
            }
        }

        return $this;
    }

    /**
     * Make a get request.
     *
     * @param  string  $method
     * @param  array   $data
     * @return array
     */
    protected function get($method, array $data = array())
    {
        $data = $this->data($data);

        if (!$this->cache[$method]) {
            $this->cache[$method] = $this->client->$method($data)->toArray();
        }

        return $this->cache[$method];
    }

    /**
     * Make a post request.
     *
     * @param  string  $method
     * @param  array   $data
     * @return array
     */
    protected function post($method, array $data = array(), $flush = null)
    {
        $data = $this->data($data);

        $this->clearCache($flush);

        return $this->client->$method($data)->toArray();
    }

    /**
     * Get the data to make a request.
     *
     * @param  array   $data
     * @return array
     */
    abstract protected function data(array $data = array());

    /**
     * Get the guzzle client instance.
     *
     * @return \GuzzleHttp\Command\Guzzle\GuzzleClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
