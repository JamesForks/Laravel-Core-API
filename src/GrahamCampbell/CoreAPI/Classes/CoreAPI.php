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

namespace GrahamCampbell\CoreAPI\Classes;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository;
use Guzzle\Common\Collection;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Plugin\Backoff\BackoffPlugin;
use Guzzle\Plugin\CurlAuth\CurlAuthPlugin;
use GrahamCampbell\CoreAPI\Responses\APIResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * This is the core api class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
class CoreAPI
{
    /**
     * The base url.
     *
     * @var string
     */
    protected $baseurl;

    /**
     * The config.
     *
     * @var \Guzzle\Common\Collection
     */
    protected $conf;

    /**
     * The auth data.
     *
     * @var array
     */
    protected $auth;

    /**
     * The auth plugin.
     *
     * @var \Guzzle\Plugin\CurlAuth\CurlAuthPlugin
     */
    protected $plugin;

    /**
     * The back off plugin.
     *
     * @var bool|\Guzzle\Plugin\Backoff\BackoffPlugin
     */
    protected $backOff;

    /**
     * The client instance.
     *
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * The cache instance.
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * The config instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Cache\CacheManager  $cache
     * @param  \Illuminate\Config\Repository   $config
     * @return void
     */
    public function __construct(CacheManager $cache, Repository $config)
    {
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Setup the instance.
     *
     * @param  string  $baseurl
     * @param  array   $config
     * @param  array   $auth
     * @param  bool|\Guzzle\Plugin\Backoff\BackoffPlugin  $backOff
     * @return void
     */
    public function setup($baseurl, array $config = array(), array $auth = array(), $backOff = true)
    {
        $this->baseurl = $baseurl;
        $this->conf = new Collection($config);

        $this->client = new Client($this->baseurl, $this->conf);

        $this->setAuth($auth);

        if (is_object($backOff)) {
            if ($backOff instanceof BackoffPlugin) {
                return $this->setBackOff($backOff);
            }
        }

        if ($backOff) {
            $this->setBackOff(BackoffPlugin::getExponentialBackoff());
        }
    }

    /**
     * Make a new default client.
     *
     * @return void
     */
    public function makeNewClient()
    {
        if (!is_string($this->baseurl) || !is_object($this->conf)) {
            throw new \BadFunctionCallException('CoreAPI has not been initialised. Please run the setup method first.');
        }

        if ($this->conf instanceof Collection) {
            throw new \BadFunctionCallException('CoreAPI has not been initialised. Please run the setup method first.');
        }

        $this->client = new Client($this->baseurl, $this->conf);

        $this->setAuth($this->auth);
        $this->setBackOff($this->backOff);
    }

    /**
     * Get the base url.
     *
     * @param  bool  $expand
     * @return string
     */
    public function getBaseUrl($expand = true)
    {
        return $this->client->getBaseUrl($expand);
    }

    /**
     * Set the base url.
     *
     * @param  string  $baseurl
     * @return void
     */
    public function setBaseUrl($baseurl)
    {
        if (!is_string($baseurl)) {
            $baseurl = '';
        }

        $this->baseurl = $baseurl;

        return $this->client->setBaseUrl($this->baseurl);
    }

    /**
     * Get the config.
     *
     * @return \Guzzle\Common\Collection
     */
    public function getConfig()
    {
        return $this->client->getConfig();
    }

    /**
     * Set the config.
     *
     * @param  array  $config
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->conf = new Collection($config);

        return $this->client->setConfig($this->conf);
    }

    /**
     * Get the auth data.
     *
     * @return array
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set the auth data.
     *
     * @param  array  $auth
     * @return void
     */
    public function setAuth(array $auth)
    {
        try {
            if (is_object($this->plugin)) {
                if ($this->plugin instanceof EventSubscriberInterface) {
                    $this->removeSubscriber($this->plugin);
                }
            }
        } catch (\Exception $e) {
            // ignore any errors fails
        }

        $this->auth = $auth;

        if (!empty($this->auth) && is_array($this->auth)) {
            if (array_key_exists('username', $this->auth) && array_key_exists('password', $this->auth)) {
                $this->plugin = new CurlAuthPlugin($this->auth['username'], $this->auth['password']);
                $this->addSubscriber($this->plugin);
            } elseif (array_key_exists('consumer_key', $this->auth) && array_key_exists('consumer_secret', $this->auth)) {
                $this->plugin = new OauthPlugin($this->auth);
                $this->addSubscriber($this->plugin);
            }
        }
    }

    /**
     * Get the back off plugin.
     *
     * @return |bool\Guzzle\Plugin\Backoff\BackoffPlugin
     */
    public function getBackOff()
    {
        return $this->backOff;
    }

    /**
     * Set the back off plugin.
     *
     * @param  \Guzzle\Plugin\Backoff\BackoffPlugin  $backOff
     * @return void
     */
    public function setBackOff($backOff)
    {
        try {
            if (is_object($this->backOff)) {
                if ($this->backOff instanceof EventSubscriberInterface) {
                    $this->removeSubscriber($this->backOff);
                }
            }
        } catch (\Exception $e) {
            // ignore any errors fails
        }

        $this->backOff = $backOff;

        if (is_object($this->backOff)) {
            if ($this->backOff instanceof BackoffPlugin) {
                $this->addSubscriber($this->backOff);
            }
        }
    }

    /**
     * Get the client instance.
     *
     * @return \Guzzle\Http\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client instance.
     *
     * @param  \Guzzle\Http\Client  $client
     * @return void
     */
    public function setClient(Client $client)
    {
        return $this->client = $client;
    }

    /**
     * Set ssl verification.
     *
     * @param  bool  $certificateAuthority
     * @param  bool  $verifyPeer
     * @param  int   $verifyHost
     * @return void
     */
    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2)
    {
        return $this->client->setSslVerification($certificateAuthority, $verifyPeer, $verifyHost);
    }

    /**
     * Add an event subscriber.
     *
     * @param  \Symfony\Component\EventDispatcher\EventSubscriberInterface  $subscriber
     * @return void
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->client->getEventDispatcher()->addSubscriber($subscriber);
    }

    /**
     * Removed an event subscriber.
     *
     * @param  \Symfony\Component\EventDispatcher\EventSubscriberInterface  $subscriber
     * @return void
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->client->getEventDispatcher()->removeSubscriber($subscriber);
    }

    /**
     * Generate a response via the specified method.
     *
     * @param  string       $method
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function goGet($method = 'GET', $uri = null, $headers = null, $body = null, array $options = array(), $cache = false)
    {
        $key = md5(json_encode($method).json_encode($uri).json_encode($headers).json_encode($body).json_encode($options));
        $time = $this->cacheTime($cache);

        // check if we are using the cache
        if ($time > 0) {
            // if so, then pull from the cache
            $value = $this->getCache($key);
            // check if the value is valid
            if (!$this->validCache($value)) {
                // if is invalid, do the work
                $value = $this->sendGet($method, $uri, $headers, $body, $options);
                // add the value from the work to the cache
                $this->setCache($key, $value, $time);
            }
        } else {
            // do the work because caching is disabled
            $value = $this->sendGet($method, $uri, $headers, $body, $options);
        }

        // spit out the response
        return $value;
    }

    /**
     * Get the cache time.
     *
     * @param  bool|int  $cache
     * @return int
     */
    protected function cacheTime($cache)
    {
        if ($cache === true) {
            $cache = $this->config['core-api::cache'];
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

        if ($this->config['core-api::cache'] === 0 && $this->config['core-api::force'] === true) {
            $cache = 0;
        }

        return $cache;
    }

    /**
     * Send a request.
     *
     * @param  string       $method
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    protected function sendGet($method, $uri, $headers, $body, array $options)
    {
        $request = $this->client->createRequest($method, $uri, $headers, $body, $options);
        return new APIResponse($request);
    }

    /**
     * Check if the cached response is valid
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function validCache($value)
    {
        if (!is_object($value)) {
            return false;
        }

        if (!$value instanceof APIResponse) {
            return false;
        }

        return true;
    }

    /**
     * Pull a response from the cache.
     *
     * @param  bool|int  $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    protected function getCache($key)
    {
        return $this->cache->section('api')->get($key);
    }

    /**
     * Add a response to the cache.
     *
     * @param  string  $key
     * @param  \GrahamCampbell\CoreAPI\Responses\APIResponse  $value
     * @param  int  $time
     * @return void
     */
    protected function setCache($key, APIResponse $value, $time)
    {
        return $this->cache->section('api')->put($key, $value, $time);
    }

    /**
     * Generate a response from a get request.
     *
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function get($uri = null, $headers = null, array $options = array(), $cache = false)
    {
        return is_array($options)
            ? $this->goGet('GET', $uri, $headers, null, $options, $cache)
            : $this->goGet('GET', $uri, $headers, $options, array(), $cache);
    }

    /**
     * Generate a response from a post request.
     *
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function post($uri = null, $headers = null, $body = null, array $options = array(), $cache = false)
    {
        return $this->goGet('POST', $uri, $headers, $body, $options, $cache);
    }

    /**
     * Generate a response from a put request.
     *
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function put($uri = null, $headers = null, $body = null, array $options = array(), $cache = false)
    {
        return $this->goGet('PUT', $uri, $headers, $body, $options, $cache);
    }

    /**
     * Generate a response from a patch request.
     *
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function patch($uri = null, $headers = null, $body = null, array $options = array(), $cache = false)
    {
        return $this->goGet('PATCH', $uri, $headers, $body, $options, $cache);
    }

    /**
     * Generate a response from a delete request.
     *
     * @param  string|null  $uri
     * @param  array|null   $headers
     * @param  array|null   $body
     * @param  array        $options
     * @param  bool|int     $cache
     * @return \GrahamCampbell\CoreAPI\Responses\APIResponse
     */
    public function delete($uri = null, $headers = null, $body = null, array $options = array(), $cache = false)
    {
        return $this->goGet('DELETE', $uri, $headers, $body, $options, $cache);
    }
}
