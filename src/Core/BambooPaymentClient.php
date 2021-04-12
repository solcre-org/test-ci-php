<?php

namespace BambooPayment\Core;

use BambooPayment\Exception\AuthenticationException;
use BambooPayment\Exception\InvalidArgumentException;
use function is_string;
use function preg_match;

/**
 * Client used to send requests to BambooPayment's API.
 *
 * {@property} \BambooPayment\Service\CustomerService $customers
 */
class BambooPaymentClient
{
    private const DEFAULT_API_BASE = 'https://api.siemprepago.com/';
    private const DEFAULT_API_TESTING_BASE = 'https://testapi.siemprepago.com/';

    private ?CoreServiceFactory $coreServiceFactory = null;
    private array $config;

    private array $defaultOpts;
    /**
     * @var AbstractService|AbstractServiceFactory|null
     */
    private $data;

    public function __construct(array $config)
    {
        if (! isset($config['api_key'])) {
            throw new InvalidArgumentException('Must provide a api key');
        }

        $config['api_base'] = self::DEFAULT_API_BASE;

        $isTestingMode = $config['testing'] ?? false;
        if ($isTestingMode) {
            $config['api_base'] = self::DEFAULT_API_TESTING_BASE;
        }

        $this->validateConfig($config);
        $this->config = $config;
        $this->defaultOpts = [];
    }

    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey(): ?string
    {
        return $this->config['api_key'];
    }

    /**
     * Gets the client ID used by the client in OAuth requests.
     *
     * @return null|string the client ID used by the client in OAuth requests
     */
    public function getClientId(): ?string
    {
        return $this->config['client_id'];
    }

    /**
     * Gets the base URL for BambooPayment's API.
     *
     * @return string the base URL for BambooPayment's API
     */
    public function getApiBase(): string
    {
        return $this->config['api_base'];
    }

    public function request(ApiRequest $apiRequest): array
    {
        $apiResponse = $apiRequest->request();

        return $apiRequest->interpretResponse($apiResponse);
    }

//    public function requestCollection(string $method, string $path, array $params, $opts): Collection
//    {
//        $obj = $this->request($method, $path, $params, $opts);
//        if (! ($obj instanceof Collection)) {
//            $received_class = get_class($obj);
//            $msg = "Expected to receive `BambooPayment\\Collection` object from BambooPayment API. Instead received `{$received_class}`.";
//
//            throw new UnexpectedValueException($msg);
//        }
//        $obj->setFilters($params);
//
//        return $obj;
//    }

    /**
     * @return string
     *
     * @throws AuthenticationException
     */
    private function apiKeyForRequest(): string
    {
        $apiKey = $this->getApiKey();

        if ($apiKey === null) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'BambooPaymentClient instance, or provide it on a per-request basis '
                . 'using the `api_key` key in the $opts argument.';

            throw new \BambooPayment\Exception\AuthenticationException($msg);
        }

        return $apiKey;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig(array $config): void
    {
        // api_key
        if ($config['api_key'] !== null && ! is_string($config['api_key'])) {
            throw new \BambooPayment\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if ($config['api_key'] !== null && ($config['api_key'] === '')) {
            $msg = 'api_key cannot be the empty string';

            throw new \BambooPayment\Exception\InvalidArgumentException($msg);
        }

        if ($config['api_key'] !== null && (preg_match('/\s/', $config['api_key']))) {
            $msg = 'api_key cannot contain whitespace';

            throw new \BambooPayment\Exception\InvalidArgumentException($msg);
        }
    }

    public function __get($name)
    {
        if (! $this->coreServiceFactory instanceof CoreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }//end __set()

    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }//end __isset()

    /**
     * @param string $method
     * @param string $path
     * @param null $params
     * @param null $opts
     *
     * @return ApiRequest
     *
     * @throws AuthenticationException
     */
    public function createApiRequest(string $method, string $path, $params = null, $opts = null): ApiRequest
    {
        if ($opts === null) {
            $opts = [];
        }

        if ($params === null) {
            $params = [];
        }

        return new ApiRequest($method, $path, $params, $this->apiKeyForRequest(), $this->getApiBase(), []);
    }
}