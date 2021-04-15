<?php

use BambooPayment\Exception\ExceptionInterface;

require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../init.php';

try {
    $customer = $bambooPaymentClient->customers->fetch(53479);

    var_dump($customer->toArray());
} catch (ExceptionInterface $e) {
    var_dump($e->getMessage());
}
