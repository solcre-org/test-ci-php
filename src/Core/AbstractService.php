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

    /**
     * @throws \BambooPayment\Exception\InvalidRequestException
     * @throws \BambooPayment\Exception\PermissionException
     * @throws \BambooPayment\Exception\AuthenticationException
     * @throws \BambooPayment\Exception\ApiErrorException
     * @throws \BambooPayment\Exception\UnknownApiErrorException
     */
    protected function request(
        string $method,
        string $path,
        ?array $params = null
    ): BambooPaymentObject {
        $response = $this->client->request($this->client->createApiRequest($method, $path, $params));

        return $this->convertToBambooPaymentObject($response);
    }

    protected function requestCollection(
        string $method,
        string $path,
        ?array $params = null
    ): array {
        $response = $this->client->request($this->client->createApiRequest($method, $path, $params));

        $result = [];
        foreach ($response as $item) {
            if (\is_array($item)) {
                $result[] = $this->convertToBambooPaymentObject($item);
            }
        }

        return $result;
    }

    protected function convertToBambooPaymentObject(array $response): ?BambooPaymentObject
    {
        $class  = $this->getEntityClass();
        $object = new $class();
        if ($object instanceof BambooPaymentObject) {
            return $object->hydrate($response);
        }

        return null;
    }

    abstract public function getEntityClass(): string;
}
