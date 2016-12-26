<?php

namespace Drupal\eventbrite_pull;

use GuzzleHttp\Exception\RequestException;

class Eventbrite {
  protected $api_endpoint = "https://www.eventbriteapi.com/v3/";
  protected $auth_token;
  protected $api_url;

  function __construct($token) {
    $this->auth_token = $token;
  }

  function get($method, $args = false) {
    $params = array();

    if($args && is_array($args)){
      $params = $args;
    }

    // Add authentication tokens to querystring
    if(!empty($this->auth_token)) {
      $params['token'] = $this->auth_token;
    }

    $uri = $this->api_endpoint . $method . '?' . http_build_query($params,'','&');
    $data = $this->getResponse($uri);

    return $data;
  }

  function getResponse($uri) {
    try {
      $client = \Drupal::service('http_client');
      $result = $client->get($uri, ['Accept' => 'application/json']);
      $contents = $result->getBody()->getContents();

      $data = \GuzzleHttp\json_decode($contents);

      return $data;
    }
    catch (RequestException $e) {
      $contents = $e->getResponse()->getBody()->getContents();

      $data = \GuzzleHttp\json_decode($contents);

      drupal_set_message($data->error_description, 'error');

      return FALSE;
    }
  }
}