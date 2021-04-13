<?php

namespace BambooPayment\Core;

use BambooPayment\Exception\ApiBadParametersException;
use BambooPayment\Exception\ApiErrorException;
use BambooPayment\Exception\AuthenticationException;
use BambooPayment\Exception\InvalidRequestException;
use BambooPayment\Exception\PermissionException;
use BambooPayment\Exception\UnexpectedValueException;
use BambooPayment\Exception\UnknownApiErrorException;

class ErrorHandler
{
    /**
     * @throws ApiBadParametersException
     * @throws PermissionException
     * @throws InvalidRequestException
     * @throws ApiErrorException
     * @throws AuthenticationException
     * @throws UnknownApiErrorException
     */
    public function handleErrorResponse(?array $body, int $code): void
    {
        $errorData = $body[BambooPaymentClient::ARRAY_ERROR_KEY] ?? null;
        if (! \is_array($body) || $errorData === null) {
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
     * @throws PermissionException
     * @throws UnknownApiErrorException
     */
    private function throwSpecificException(array $errorData, int $code, array $body): void
    {
        $bambooPaymentErrorCode = $errorData['ErrorCode'] ?? null;
        $bambooPaymentMessage = $errorData['Message'] ?? null;
        $bambooPaymentDetail = $errorData['Detail'] ?? null;

        switch ($code) {
            case 400:
//                if ('idempotency_error' === $type) {
//                    return Exception\IdempotencyException($msg, $rcode, $rbody, $resp, $rheaders, $code);
//                }
                throw new ApiBadParametersException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);
            case 404:
                throw new InvalidRequestException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);

            case 401:
                throw new AuthenticationException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);

            case 403:
                throw new PermissionException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);

            default:
                throw new UnknownApiErrorException($bambooPaymentMessage, $code, $body, $bambooPaymentErrorCode, $bambooPaymentDetail);
        }
    }
}
