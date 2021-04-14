<?php

namespace BambooPayment\Core;

use BambooPayment\Entity\BambooPaymentObject;

abstract class AbstractService
{
    protected BambooPaymentClient $client;

    public function __construct(BambooPaymentClient $client)
    {
        $this->client = $client;
    }

    protected function request(
        string $method,
        string $path,
        string $class,
        ?array $params = null
    ): BambooPaymentObject {
        $response = $this->client->request($this->client->createApiRequest($method, $path, $params));

        return $this->convertToBambooPaymentObject($class, $response);
    }

    protected function requestCollection(
        string $method,
        string $path,
        string $class,
        ?array $params = null,
        ?array $opts = null
    ): array {
        $response = $this->client->request($this->client->createApiRequest($method, $path, $params));

        $result = [];
        foreach ($response as $item) {
            if (\is_array($item)) {
                $result[] = $this->convertToBambooPaymentObject($class, $item);
            }
        }

        return $result;
    }

    protected function convertToBambooPaymentObject(string $class, array $response): ?BambooPaymentObject
    {
        $object = new $class();
        if ($object instanceof BambooPaymentObject) {
            return $object->hydrate($class, $response);
        }

        return null;
    }
}
