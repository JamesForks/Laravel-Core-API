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
     * The request cache.
     *
     * @var array
     */
    protected $cache = array();

    /**
     * The guzzle client class.
     *
     * @var \GuzzleHttp\Command\Guzzle\GuzzleClient
     */
    protected $client;

    /**
     * Create a new model instance.
     *
     * @param  \GuzzleHttp\Command\Guzzle\GuzzleClient  $client
     * @return void
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Clear the request cache.
     *
     * @param  string  $method
     * @return void
     */
    public function clearCache($method = null)
    {
        if ($cache) {
            $this->cache['method'] = array();
        } else {
            $this->cache = array();
        }

        return $this;
    }

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
