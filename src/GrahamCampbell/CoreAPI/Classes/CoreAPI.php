<?php namespace GrahamCampbell\CoreAPI\Classes;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class CoreAPI {

    protected $url;
    protected $config;
    protected $oauth;
    protected $client;

    protected function makeNewClient() {
        $this->client = new Client($this->url, $this->config);

        if ($this->oauth) {
            $oauth = new OauthPlugin($oauth);
            $this->client->addSubscriber($oauth));
        }
    }

    public function setUp($url, $config = null, $oauth = null) {
        $this->url = $url;
        $this->config = $config;
        $this->oauth = $oauth;

        $this->makeNewClient();
    }

    public function reset() {
        if ($this->url) {
            $this->makeNewClient();
        }
    }

    public function getClient() {
        return $this->client;
    }

    public function sendGet($uri = null, $headers = null, $options = array()) {
        return $this->client->get($uri, $headers, $options)->send();
    }

    public function goGet($uri = null, $headers = null, $options = array()) {
        return $this->client->get($uri, $headers, $options)->send()->getBody();
    }

    public function sendHead($uri = null, $headers = null, array $options = array()) {
        return $this->client->head($uri, $headers, $options)->send();
    }

    public function goHead($uri = null, $headers = null, array $options = array()) {
        return $this->client->head($uri, $headers, $options)->send()->getBody();
    }

    public function sendDelete($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->delete($uri, $headers, $body, $options)->send();
    }

    public function goDelete($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->delete($uri, $headers, $body, $options)->send()->getBody();
    }

    public function sendPut($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->put($uri, $headers, $body, $options)->send();
    }

    public function goPut($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->put($uri, $headers, $body, $options)->send()->getBody();
    }

    public function sendPatch($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->patch($uri, $headers, $body, $options)->send();
    }

    public function goPatch($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->patch($uri, $headers, $body, $options)->send()->getBody();
    }

    public function sendPost($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->post($uri, $headers, $body, $options)->send();
    }

    public function goPost($uri = null, $headers = null, $body = null, array $options = array()) {
        return $this->client->post($uri, $headers, $body, $options)->send()->getBody();
    }

    public function sendOptions($uri = null, array $options = array()) {
        return $this->client->options($uri, $options)->send();
    }

    public function goOptions($uri = null, array $options = array()) {
        return $this->client->options($uri, $options)->send()->getBody();
    }

    // i hope this is correct...
    private function __call($method, $args) {
        if (in_array($method, self::$methods)) {
            return call_user_func_array('$this->client->'.$method, $args);
        }
    }
}
