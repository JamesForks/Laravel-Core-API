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

namespace GrahamCampbell\CoreAPI\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Retry\RetrySubscriber;
use GrahamCampbell\Manager\Interfaces\ConnectorInterface;

/**
 * This is the abstract client connector class.
 *
 * @package    Laravel-Core-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Core-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Core-API
 */
abstract class AbstractConnector implements ConnectorInterface
{
    /**
     * Make a new guzzle client.
     *
     * @param  array  $config
     * @return \GuzzleHttp\Client
     */
    public function connect(array $config)
    {
        $parameters = $this->getParameters($config);

        $client = $this->getClient($parameters);

        return $this->attachSubscribers($client);
    }

    /**
     * Get the client constructor parameters.
     *
     * @param  array  $config
     * @return array
     */
    abstract protected function getParameters(array $config);

    /**
     * Get the client.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Client
     */
    public function getClient($parameters)
    {
        return new Client($parameters);
    }

    /**
     * Attach all subscribers to the guzzle client.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return \GuzzleHttp\Client
     */
    protected function attachSubscribers($client)
    {
        $subscribers = $this->getSubscribers();

        foreach ($subscribers as $subscriber) {
            $client->getEmitter()->attach($subscriber);
        }

        return $client;
    }

    /**
     * Get all subscribers.
     *
     * @return array
     */
    protected function getSubscribers()
    {
        $subsribers = array();

        $names = $this->getSubscriberNames();

        foreach ($names as $name) {
            $subsribers[] = $this->{"get{$name}Subscriber"}();
        }

        return $subsribers;
    }

    /**
     * Get all subscriber names.
     *
     * @return array
     */
    protected function getSubscriberNames()
    {
        // TODO: Cache subscriber
        return array('Retry');
    }

    /**
     * Get the retry subscriber.
     *
     * @return \GuzzleHttp\Subscriber\Retry\RetrySubscriber
     */
    protected function getRetrySubscriber()
    {
        $filter = RetrySubscriber::createChainFilter(array(
            RetrySubscriber::createIdempotentFilter(),
            RetrySubscriber::createStatusFilter()
        ));

        return new RetrySubscriber(array('filter' => $filter));
    }
}
