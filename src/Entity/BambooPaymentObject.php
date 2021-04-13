<?php

namespace BambooPayment\Entity;

use GeneratedHydrator\Configuration;
use GeneratedHydrator\GeneratedHydrator;

class BambooPaymentObject
{
    private function getHydrator(string $class): GeneratedHydrator
    {
        $config        = new Configuration($class);
        $hydratorClass = $config->createFactory()->getHydratorClass();

        return new $hydratorClass();
    }

    public function hydrate(string $class, array $data): self
    {
        $object = new $class();

        $hydrator = $this->getHydrator($class);
        $hydrator->hydrate($data, $object);

        return $object;
    }
}
