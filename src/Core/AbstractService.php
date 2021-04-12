<?php

namespace BambooPayment\Core;

use BambooPayment\Collection;
use BambooPayment\Entity\BambooPaymentObject;
use GeneratedHydrator\Configuration;

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

    protected function request(string $method, string $path, string $class, ?array $params = null, ?array $opts = null): BambooPaymentObject
    {
        $response = $this->client->request($this->client->createApiRequest($method, $path, $params, $opts));

        return $this->convertToBambooPaymentObject($class, $response);
    }

//    protected function requestCollection($method, $path, $params, $opts): Collection
//    {
//        return $this->getClient()->requestCollection($method, $path, $params, $opts);
//    }

    protected function convertToBambooPaymentObject(string $class, array $response): BambooPaymentObject
    {
        $config = new Configuration($class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();
        $object = new $class();

        $hydrator->hydrate($response, $object);

        return $object;
    }
}
