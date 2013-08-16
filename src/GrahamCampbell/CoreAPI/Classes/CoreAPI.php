<?php namespace GrahamCampbell\CoreAPI\Classes;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class CoreAPI {

    protected $baseurl;
    protected $config;
    protected $oauth;
    protected $userAgent;
    protected $client;

    public function setUp($baseurl, $config = array(), $oauth = null, $userAgent = null) {
        $this->baseurl = $baseurl;
        $this->config = new Collection($config);
        $this->oauth = $oauth;
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


    public function getAllEvents() {
        return $this->client->getAllEvents();
    }

    public function createRequest($method = 'GET', $uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->createRequest($method, $uri, $headers, $body, $options);
    }

    public function send($requests) {
        return $this->client->send($requests);
    }


    public function get($uri = null, $headers = null, $options = array()) {
        return $this->client->get($uri, $headers, $options);
    }

    public function sendGet($uri = null, $headers = null, $options = array()) {
        return $this->client->get($uri, $headers, $options)->send();
    }

    public function goGet($uri = null, $headers = null, $options = array()) {
        return $this->client->get($uri, $headers, $options)->send()->getBody();
    }

    public function head($uri = null, $headers = null, array $options = array()) {
        return $this->client->head($uri, $headers, $options);
    }

    public function sendHead($uri = null, $headers = null, array $options = array()) {
        return $this->client->head($uri, $headers, $options)->send();
    }

    public function goHead($uri = null, $headers = null, array $options = array()) {
        return $this->client->head($uri, $headers, $options)->send()->getBody();
    }

    public function delete($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->delete($uri, $headers, $body, $options);
    }

    public function sendDelete($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->delete($uri, $headers, $body, $options)->send();
    }

    public function goDelete($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->delete($uri, $headers, $body, $options)->send()->getBody();
    }

    public function put($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->put($uri, $headers, $body, $options);
    }

    public function sendPut($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->put($uri, $headers, $body, $options)->send();
    }

    public function goPut($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->put($uri, $headers, $body, $options)->send()->getBody();
    }

    public function patch($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->patch($uri, $headers, $body, $options);
    }

    public function sendPatch($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->patch($uri, $headers, $body, $options)->send();
    }

    public function goPatch($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->patch($uri, $headers, $body, $options)->send()->getBody();
    }

    public function post($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->post($uri, $headers, $body, $options);
    }

    public function sendPost($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->post($uri, $headers, $body, $options)->send();
    }

    public function goPost($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->post($uri, $headers, $body, $options)->send()->getBody();
    }

    public function options($uri = null, array $options = array()) {
        return $this->client->options($uri, $options);
    }

    public function sendOptions($uri = null, array $options = array()) {
        return $this->client->options($uri, $options)->send();
    }

    public function goOptions($uri = null, array $options = array()) {
        return $this->client->options($uri, $options)->send()->getBody();
    }
}
