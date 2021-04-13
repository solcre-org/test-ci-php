<?php

namespace BambooPaymentTests;

use BambooPayment\Core\ApiRequest;
use BambooPayment\Core\ApiResponse;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    public function mockApiRequest($filename, $endpoint, $statusCode = null): ApiRequest
    {
        if ($statusCode === null) {
            $statusCode = 200;
        }

        $apiRequest = $this->createPartialMock(ApiRequest::class, ['request']);
        $apiRequest->method('request')->willReturn(new ApiResponse($this->getMockData($filename, $endpoint), $statusCode));

        return $apiRequest;
    }

    /**
     * @throws \JsonException
     */
    private function getMockData($filename, $endpoint): ?string
    {
        $data     = null;
        $filename = __DIR__ . '/Data/' . $filename . '.json';
        if (\file_exists($filename)) {
            $mockFile = \json_decode(\file_get_contents($filename), true, 512, JSON_THROW_ON_ERROR);
            $data     = $mockFile[$endpoint]['data'];
        }

        return $data;
    }
}
