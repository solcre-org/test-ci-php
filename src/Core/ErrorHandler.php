<?php

namespace BambooPayment\Core;

use BambooPayment\Exception\ApiBadParametersException;
use BambooPayment\Exception\ApiErrorException;
use BambooPayment\Exception\AuthenticationException;
use BambooPayment\Exception\InvalidRequestException;
use BambooPayment\Exception\UnexpectedValueException;
use BambooPayment\Exception\UnknownApiErrorException;
use function is_array;

class ErrorHandler
{
    /**
     * @throws ApiBadParametersException
     * @throws InvalidRequestException
     * @throws ApiErrorException
     * @throws AuthenticationException
     * @throws UnknownApiErrorException
     */
    public function handleErrorResponse(?array $body, int $code): void
    {
        $errorData = $body[BambooPaymentClient::ARRAY_ERROR_KEY] ?? null;
        if (! is_array($body) || $errorData === null) {
            throw new UnexpectedValueException('Invalid response object from API');
        }

        if (isset($errorData[0])) {
            $this->throwSpecificException($errorData[0], $code, $body);
        }
    }

    /**
     * @param array $errorData
     * @param int $code
     * @param array $body
     *
     * @throws ApiBadParametersException
     * @throws AuthenticationException
     * @throws InvalidRequestException
     * @throws UnknownApiErrorException
     */
    private function throwSpecificException(array $errorData, int $code, array $body): void
    {
        $bambooPaymentErrorCode = $errorData['ErrorCode'] ?? null;
        $bambooPaymentMessage   = $errorData['Message'] ?? null;
        $bambooPaymentDetail    = $errorData['Detail'] ?? null;

        switch ($code) {
            case 400:
                throw new ApiBadParametersException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);
            case 404:
                throw new InvalidRequestException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);

            case 401:
                throw new AuthenticationException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);

            default:
                throw new UnknownApiErrorException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);
        }
    }
}
