<?php

namespace BambooPaymentTests\Service;

use BambooPayment\Core\BambooPaymentClient;
use BambooPayment\Exception\ApiBadParametersException;
use BambooPayment\Service\CustomerService;
use BambooPaymentTests\BaseTest;

class CustomerServiceTest extends BaseTest
{

    public function testFetchCustomer(): void
    {
        $apiRequest = $this->mockApiRequest('customers', 'getCustomer');

        $bambooPaymentClient = $this->createPartialMock(BambooPaymentClient::class, ['createApiRequest']);
        $bambooPaymentClient->method('createApiRequest')->willReturn($apiRequest);
        $service = new CustomerService($bambooPaymentClient);

        $customer = $service->fetch(53479);

        self::assertEquals('Email@bamboopayment.com', $customer->getEmail());
    }

    public function testCreateCustomerWithoutEmail(): void
    {
        $apiRequest = $this->mockApiRequest('customers', 'createCustomerWithoutEmail', 400);

        $bambooPaymentClient = $this->createPartialMock(BambooPaymentClient::class, ['createApiRequest']);
        $bambooPaymentClient->method('createApiRequest')->willReturn($apiRequest);
        $service = new CustomerService($bambooPaymentClient);

        $this->expectException(ApiBadParametersException::class);
        $this->expectExceptionMessage('Email invalido');

        $service->create([
            'FirstName'      => 'PrimerNombre',
            'LastName'       => 'PrimerApellido',
            'DocNumber'      => 12345672,
            'DocumentTypeId' => 2,
            'PhoneNumber'    => '24022330',
            'BillingAddress' => [
                'AddressType'   => 1,
                'Country'       => 'UY',
                'State'         => 'Montevideo',
                'City'          => 'MONTEVIDEO',
                'AddressDetail' => '10000'
            ]
        ]);
    }

}
