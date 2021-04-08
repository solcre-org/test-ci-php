<?php

namespace BambooPayment\HttpClient;

use BambooPayment\Exception\UnexpectedValueException;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use function strtolower;

class HttpClient
{
    protected static $instance;

    public static function instance(): HttpClient
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected $defaultOptions;
    protected ClientInterface $client;

    public function __construct($defaultOptions = null)
    {
        $this->client = new GuzzleClient();
        $this->defaultOptions = $defaultOptions;
    }


    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    public function request($method, $absUrl, $headers, $params): ResponseInterface
    {
        $method = strtolower($method);
        if ($method !== 'get' && $method !== 'post') {
            throw new UnexpectedValueException("Unrecognized method {$method}");
        }

        return $this->client->$method($absUrl, [
            'headers'     => $headers,
            'json'        => $params,
            'http_errors' => false
        ]);
    }
}
