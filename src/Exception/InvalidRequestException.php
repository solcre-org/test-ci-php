<?php

namespace BambooPayment\Exception;

use BambooPayment\Util\CaseInsensitiveArray;

/**
 * InvalidRequestException is thrown when a request is initiated with invalid
 * parameters.
 */
class InvalidRequestException extends ApiErrorException
{
    protected $stripeParam;

    /**
     * Creates a new InvalidRequestException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the BambooPayment error code
     *
     * @return InvalidRequestException
     */
    public static function factory(
        string $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $stripeCode = null
    ): InvalidRequestException {
        $instance = parent::factory($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders, $stripeCode);
        $instance->setBambooPaymentParam($stripeParam);

        return $instance;
    }

    /**
     * Gets the parameter related to the error.
     *
     * @return null|string
     */
    public function getBambooPaymentParam(): ?string
    {
        return $this->stripeParam;
    }

    /**
     * Sets the parameter related to the error.
     *
     * @param null|string $stripeParam
     */
    public function setBambooPaymentParam(?string $stripeParam): void
    {
        $this->stripeParam = $stripeParam;
    }
}
