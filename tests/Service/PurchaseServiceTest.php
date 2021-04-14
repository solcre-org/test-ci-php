<?php

namespace BambooPaymentTests\Service;

use BambooPayment\Core\BambooPaymentClient;
use BambooPayment\Service\PurchaseService;
use BambooPaymentTests\BaseTest;

class PurchaseServiceTest extends BaseTest
{
    public function testCreatePurchase(): void
    {
        $apiRequest = $this->mockApiRequest('purchases', 'testCreatePurchase', 400);

        $bambooPaymentClient = $this->createPartialMock(BambooPaymentClient::class, ['createApiRequest']);
        $bambooPaymentClient->method('createApiRequest')->willReturn($apiRequest);
        $service = new PurchaseService($bambooPaymentClient);

        $payment = $service->create();

        self::assertEquals(90335, $payment->getPurchaseId());
    }
}
