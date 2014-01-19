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

namespace GrahamCampbell\CoreAPI\Responses;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * This is the api response class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
class APIResponse
{
    /**
     * The request instance.
     *
     * @var \Guzzle\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * The response instance.
     *
     * @var \Guzzle\Http\Message\Response
     */
    protected $response;

    /**
     * Create a new instance.
     *
     * @param  \Guzzle\Http\Message\RequestInterface  $request
     * @return void
     */
    public function __construct(RequestInterface $request)
    {
        $this->response = $request->send();
        $this->request = $request;
    }

    /**
     * Set the request instance.
     *
     * @param  \Guzzle\Http\Message\RequestInterface  $request
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request instance.
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the response instance.
     *
     * @param  \Guzzle\Http\Message\Response  $request
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the response instance.
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Dynamically call methods on the response.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->response, $method), $parameters);
    }
}