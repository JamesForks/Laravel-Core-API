<?php namespace GrahamCampbell\CoreAPI\Classes;

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
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @license    Apache License
 * @copyright  Copyright 2013 Graham Campbell
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

class APIResponse {

    protected $request;
    protected $response;

    public function __construct(RequestInterface $request) {
        $this->response = $request->send();
        $this->request = $request;
    }

    /**
     * Set the request that caused the exception.
     *
     * @param RequestInterface  $request
     */
    public function setRequest(RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * Get the request that caused the exception.
     *
     * @return RequestInterface
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * Set the response that caused the exception.
     *
     * @param Response  $response
     */
    public function setResponse(Response $response) {
        $this->response = $response;
    }

    /**
     * Get the response that caused the exception.
     *
     * @return Response
     */
    public function getResponse() {
        return $this->response;
    }
}
