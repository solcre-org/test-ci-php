<?php

namespace BambooPayment\Core;

use BambooPayment\Collection;
use BambooPayment\Entity\BambooPaymentObject;
use BambooPayment\Exception\InvalidArgumentException;
use GeneratedHydrator\Configuration;
use function trim;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    /**
     * @var BambooPaymentClient
     */
    protected BambooPaymentClient $client;

    public function __construct(BambooPaymentClient $client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return BambooPaymentClient
     */
    public function getClient(): BambooPaymentClient
    {
        return $this->client;
    }

    protected function request($method, $path, $class, $params = null, $opts = null): BambooPaymentObject
    {
        $response = $this->getClient()->request($method, $path, $params, $opts);
        return $this->convertToBambooPaymentObject($class, $response);
    }

    protected function requestCollection($method, $path, $params, $opts): Collection
    {
        return $this->getClient()->requestCollection($method, $path, $params, $opts);
    }

    protected function validateId(int $id): void
    {
        if ($id === null || trim($id) === '') {
            $msg = 'The resource ID cannot be null or whitespace.';

            throw new InvalidArgumentException($msg);
        }
    }

    protected function convertToBambooPaymentObject($class, $response): BambooPaymentObject
    {
        $config = new Configuration($class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();
        $object = new $class();

        $hydrator->hydrate($response, $object);

        return $object;
    }
}
