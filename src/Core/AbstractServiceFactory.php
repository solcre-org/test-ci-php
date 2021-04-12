<?php

namespace BambooPayment\Core;

use function array_key_exists;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \BambooPayment\BambooPaymentClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class AbstractServiceFactory
{

    /**
     * @var BambooPaymentClient
     */
    private BambooPaymentClient $client;

    /**
     * @var array<string, AbstractService|AbstractServiceFactory>
     */
    private array $services;
    /**
     * @var AbstractService|AbstractServiceFactory|null
     */
    private $data;

    /**
     * @param BambooPaymentClient $client
     */
    public function __construct(\BambooPayment\Core\BambooPaymentClient $client)
    {
        $this->client = $client;
        $this->services = [];
    }//end __construct()

    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function getServiceClass(string $name): ?string;

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get(string $name)
    {
        $serviceClass = $this->getServiceClass($name);
        if ($serviceClass !== null) {
            if ( ! array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        return null;
    }//end __get()

    public function __set($name, $value): void
    {
        $this->data[$name] = $value;
    }//end __set()

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }//end __isset()
}//end class
