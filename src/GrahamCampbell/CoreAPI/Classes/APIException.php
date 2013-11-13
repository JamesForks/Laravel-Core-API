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

use RuntimeException;

class APIException extends RuntimeException {

    protected $statusCode;
    protected $headers;
    protected $body;

    public function __construct($statusCode, $message = null, $body = null, array $headers = array(), $code = 0) {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;

        parent::__construct($message, $code, null);
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getBody() {
        return $this->headers;
    }

    public function decodeBody() {
        return json_decode($this->body, true);
    }

    public function isDecodable() {
        $decode = $this->decodeBody();

        if (is_null($decode)) {
            return false;
        }

        if (!is_array($decode) || empty($decode)) {
            return false;
        }

        return true;
    }
}
