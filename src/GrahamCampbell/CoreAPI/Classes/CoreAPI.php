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

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use Guzzle\Common\Collection;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class CoreAPI {

    protected $baseurl;
    protected $config;
    protected $oauth;
    protected $auth;
    protected $userAgent;
    protected $client;

    public function setUp($baseurl, $config = array(), $authentication = null, $userAgent = null) {
        $this->baseurl = $baseurl;

        $this->config = new Collection($config);

        if (isset($authentication['user'])) {
            $this->auth = $authentication;
            $this->oauth = null;
        } else {
            $this->auth = null;
            $this->oauth = $authentication;
        }
        
        $this->userAgent = $userAgent;

        $this->makeNewClient();
    }

    protected function makeNewClient() {
        $this->client = new Client($this->baseurl, $this->config);

        if ($this->oauth) {
            $this->setOauth($this->oauth);
        }

        if ($this->userAgent) {
            $this->setUserAgent($this->userAgent);
        }
    }

    public function reset() {
        if ($this->baseurl) {
            $this->makeNewClient();
        }
    }


    public function getBaseUrl($expand = true) {
        return $this->client->getBaseUrl($expand);
    }

    public function setBaseUrl($baseurl) {
        $this->baseurl = $baseurl;
        return $this->client->setBaseUrl($this->baseurl);
    }

    public function getConfig() {
        return $this->client->getConfig();
    }

    public function setConfig($config) {
        $this->config = new Collection($config);
        return $this->client->setConfig($this->config);
    }

    public function getOauth() {
        return $this->oauth;
    }

    public function setOauth($oauth) {
        $this->oauth = $oauth;
        $oauth = new OauthPlugin($oauth);
        $this->client->addSubscriber($oauth);
    }

    public function setAuth($auth) {
        $this->auth = $auth;
    }

    public function getAuth() {
        return $this->auth;
    }

    public function getUserAgent() {
        return $this->userAgent();
    }

    public function getDefaultUserAgent() {
        return $this->client->getDefaultUserAgent();
    }

    public function setUserAgent($userAgent, $includeDefault = false) {
        if ($includeDefault) {
            $userAgent .= ' ' . $this->getDefaultUserAgent();
        }
        $this->userAgent = $userAgent;
        return $this->client->setUserAgent($this->userAgent);
    }

    public function setDefaultOption($keyOrPath, $value) {
        return $this->client->setDefaultOption($keyOrPath, $value);
    }

    public function getDefaultOption($keyOrPath) {
        return $this->client->getDefaultOption($keyOrPath);
    }

    public function getClient() {
        return $this->client;
    }

    public function setClient($client) {
        return $this->client = $client;
    }

    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2) {
        return $this->client->setSslVerification($certificateAuthority, $verifyPeer, $verifyHost);
    }


    public function goGet($method = 'GET', $uri = null, $headers = null, $body = null, array $options = array(), $cache = false) {
        $key = $this->getKey($method, $uri, $headers, $body, $options);
        $time = $this->cacheTime($cache);

        // if should cache
        Log::debug('checking if should pull from the cache');
        if ($time > 0) {
            Log::debug('decided to PULL from the cache');
            // check if the cache needs regenerating
            Log::debug('checking if the cache is valid');
            if ($this->validCache($key)) {
                Log::debug('decided the cache is VALID');
                // if so, then pull from the cache
                Log::debug('PULLING FROM THE CACHE');
                $value = $this->getCache($key);
                // check if the value is valid
                Log::debug('checking if the value is valid');
                if (!$this->validValue($value)) {
                    Log::debug('decided the value is NOT valid');
                    // if is invalid, do the work
                    Log::debug('DOING THE WORK');
                    $value = $this->sendGet($method, $uri, $headers, $body, $options);
                    // add the value from the work to the cache
                    Log::debug('SETTING THE CACHE');
                    $this->setCache($key, $value, $time);
                }
            } else {
                Log::debug('decided the cache is NOT valid');
                // if regeneration is needed, do the work
                Log::debug('DOING THE WORK');
                $value = $this->sendGet($method, $uri, $headers, $body, $options);
                // add the value from the work to the cache
                Log::debug('SETTING THE CACHE');
                $this->setCache($key, $value, $time);
            }
        } else {
            Log::debug('decided NOT to pull from the cache');
            // do the work because caching is disabled
            Log::debug('DOING THE WORK');
            $value = $this->sendGet($method, $uri, $headers, $body, $options);
        }

        // spit out the response
        return new APIResponse($value['statusCode'], $value['body'], $value['headers']);
    }

    protected function getKey($method, $uri, $headers, $body, $options) {
        return md5(json_encode($method).json_encode($uri).json_encode($headers).json_encode($body).json_encode($options));
    }

    protected function cacheTime($cache) {
        if ($cache === true) {
            $cache = Config::get('core-api::cache');
        } elseif ($cache === false) {
            $cache = 0;
        } elseif (is_numeric($cache)) {
            $cache = (int)$cache;
        }

        if (!is_int($cache)) {
            $cache = 0;
        }

        if ($cache  < 0) {
            $cache = 0;
        }

        if (Config::get('core-api::cache') === 0 && Config::get('core-api::force') === true) {
            $cache = 0;
        }

        return $cache;
    }

    protected function validCache($key) {
        return Cache::section('api')->has($key);
    }

    protected function getCache($key) {
        return Cache::section('api')->get($key);
    }

    protected function validValue($value) {
        if (is_null($value) || !is_array($value)) {
            return false;
        }

        if (!array_key_exists('statusCode', $value) || !array_key_exists('body', $value) || !array_key_exists('headers', $value)) {
        return false;
        }

        return true;
    }

    protected function sendGet($method, $uri, $headers, $body, $options) {
        $request = $this->client->createRequest($method, $uri, $headers, $body, $options)->send();

        if ($request->isSuccessful() !== true) {
            throw new APIException($request->getStatusCode(), null, $request->getBody(true), $request->getHeaders()->toArray());
            
        }

        return array('statusCode' => $request->getStatusCode(), 'body' => $request->getBody(true), 'headers' => $request->getHeaders()->toArray());
    }

    protected function setCache($key, $value, $time) {
        return Cache::section('api')->put($key, $value, $time);
    }

    public function get($uri = null, $headers = null, $options = array(), $cache = false) {
        return is_array($options)
            ? $this->goGet('GET', $uri, $headers, null, $options, $cache)
            : $this->goGet('GET', $uri, $headers, $options, array(), $cache);
    }

    public function post($uri = null, $headers = null, $body = null, $options = array(), $cache = false) {
        return $this->goGet('POST', $uri, $headers, $body, $options, $cache);
    }

    public function put($uri = null, $headers = null, $body = null, $options = array(), $cache = false) {
        return $this->goGet('PUT', $uri, $headers, $body, $options, $cache);
    }

    public function patch($uri = null, $headers = null, $body = null, $options = array(), $cache = false) {
        return $this->goGet('PATCH', $uri, $headers, $body, $options, $cache);
    }

    public function delete($uri = null, $headers = null, $body = null, $options = array(), $cache = false) {
        return $this->goGet('DELETE', $uri, $headers, $body, $options, $cache);
    }
}
