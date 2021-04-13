<?php

namespace BambooPayment\HttpClient;

use BambooPayment\Exception\BadMethodCallException;
use BambooPayment\Exception\UnexpectedValueException;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use function strtolower;

final class HttpClient
{
    protected static ?HttpClient $instance = null;

    public static function instance(): ?HttpClient
    {
        if ( ! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
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

    public function request(string $method, string $absUrl, array $headers, array $params): ResponseInterface
    {
        $method = strtolower($method);
        if ($method !== 'get' && $method !== 'post') {
            throw new UnexpectedValueException("Unrecognized method {$method}");
        }

        if (\is_callable([$this->client, $method])) {
            return $this->client->$method($absUrl, [
                'headers' => $headers,
                'json' => $params,
                'http_errors' => false
            ]);
        }

        throw new BadMethodCallException("Method: {$method} does not exists");
    }
}
