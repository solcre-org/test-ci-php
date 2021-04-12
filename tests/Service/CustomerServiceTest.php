<?php

namespace BambooPaymentTests\Service;

use BambooPayment\Core\BambooPaymentClient;
use BambooPayment\Entity\Customer;
use BambooPayment\Service\CustomerService;
use BambooPaymentTests\BaseTest;

class CustomerServiceTest extends BaseTest
{
    private CustomerService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $apiRequest = $this->mockApiRequest('customers', 'getCustomer');

        $bambooPaymentClient = $this->createPartialMock(BambooPaymentClient::class, ['createApiRequest']);
        $bambooPaymentClient->method('createApiRequest')->willReturn($apiRequest);
        $this->service = new CustomerService($bambooPaymentClient);
    }


    public function testFetchCustomer(): void
    {
        /* @var Customer $customer */
        $customer = $this->service->fetch(53479);
        self::assertInstanceOf(Customer::class, $customer);
        self::assertEquals('Email@bamboopayment.com', $customer->getEmail());
    }

}
