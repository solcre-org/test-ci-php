<?php

namespace BambooPayment\Core;

use BambooPayment\Collection;
use BambooPayment\Exception\ApiErrorException;
use BambooPayment\Exception\AuthenticationException;
use BambooPayment\Exception\InvalidArgumentException;
use Bamboopayment\Exception\UnexpectedValueException;
use BambooPayment\Util\RequestOptions;
use function get_class;
use function is_array;
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

    private $coreServiceFactory;
    private array $config;

    private array $defaultOpts;

    /**
     * Initializes a new instance of the {@link BaseBambooPaymentClient} class.
     *
     * The constructor takes a single argument. The argument can be a string, in which case it
     * should be the API key. It can also be an array with various configuration settings.
     *
     * Configuration settings include the following options:
     *
     * - api_key (null|string): the BambooPayment API key, to be used in regular API requests.
     * - client_id (null|string): the BambooPayment client ID, to be used in OAuth requests.
     * - stripe_account (null|string): a BambooPayment account ID. If set, all requests sent by the client
     *   will automatically use the {@code BambooPayment-Account} header with that account ID.
     * - stripe_version (null|string): a BambooPayment API verion. If set, all requests sent by the client
     *   will include the {@code BambooPayment-Version} header with that API version.
     *
     * The following configuration settings are also available, though setting these should rarely be necessary
     * (only useful if you want to send requests to a mock server like stripe-mock):
     *
     * - api_base (string): the base URL for regular API requests. Defaults to
     *   {@link DEFAULT_API_BASE}.
     * - connect_base (string): the base URL for OAuth requests. Defaults to
     *   {@link DEFAULT_CONNECT_BASE}.
     * - files_base (string): the base URL for file creation requests. Defaults to
     *   {@link DEFAULT_FILES_BASE}.
     *
     * @param array<string, mixed>|string $config the API key as a string, or an array containing
     *   the client configuration settings
     */
    public function __construct($config = [])
    {
        if (is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (! is_array($config)) {
            throw new InvalidArgumentException('$config must be a string or an array');
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

    /**
     * Sends a request to BambooPayment's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param null $params the parameters of the request
     * @param null $opts the special modifiers of the request
     *
     * @return array the object returned by BambooPayment's API
     * @throws ApiErrorException
     * @throws AuthenticationException
     * @throws \JsonException
     */
    public function request(string $method, string $path, $params = null, $opts = null): array
    {
//        $opts = $this->defaultOpts->merge($opts, true);
        $opts = [];
        $baseUrl = $this->getApiBase();
        $requestor = new ApiRequestor($this->apiKeyForRequest($opts), $baseUrl);
        return $requestor->request($method, $path, $params, null);
    }

    /**
     * Sends a request to BambooPayment's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|RequestOptions $opts the special modifiers of the request
     *
     * @return Collection of ApiResources
     * @throws ApiErrorException
     * @throws AuthenticationException
     */
    public function requestCollection(string $method, string $path, array $params, $opts): Collection
    {
        $obj = $this->request($method, $path, $params, $opts);
        if (! ($obj instanceof Collection)) {
            $received_class = get_class($obj);
            $msg = "Expected to receive `BambooPayment\\Collection` object from BambooPayment API. Instead received `{$received_class}`.";

            throw new UnexpectedValueException($msg);
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     *
     * @param array $opts
     * @return string
     * @throws AuthenticationException
     */
    private function apiKeyForRequest(array $opts): string
    {
        $apiKey = $this->getApiKey();

        if ($apiKey === null) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'BambooPaymentClient instance, or provide it on a per-request basis '
                . 'using the `api_key` key in the $opts argument.';

            throw new \Bamboopayment\Exception\AuthenticationException($msg);
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
            throw new \Bamboopayment\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if ($config['api_key'] !== null && ($config['api_key'] === '')) {
            $msg = 'api_key cannot be the empty string';

            throw new \Bamboopayment\Exception\InvalidArgumentException($msg);
        }

        if ($config['api_key'] !== null && (preg_match('/\s/', $config['api_key']))) {
            $msg = 'api_key cannot contain whitespace';

            throw new \Bamboopayment\Exception\InvalidArgumentException($msg);
        }
    }

    public function __get($name)
    {
        if ($this->coreServiceFactory === null) {
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
}
