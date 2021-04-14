<?php

namespace BambooPayment\Core;

use BambooPayment\Service\CustomerService;

class CoreServiceFactory extends AbstractServiceFactory
{
    /***
     * @var array<string, string>
     */
    private static array $classMap
        = [
            'customers' => CustomerService::class,
        ];

    public function getServiceClass(string $name): ?string
    {
        return self::$classMap[$name] ?? null;
    }
}
