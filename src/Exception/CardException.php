<?php

namespace BambooPayment\Exception;

use BambooPayment\Util\CaseInsensitiveArray;

/**
 * CardException is thrown when a user enters a card that can't be charged for
 * some reason.
 */
class CardException extends ApiErrorException
{
    protected ?string $declineCode;
    protected $stripeParam;

    /**
     * Creates a new CardException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the BambooPayment error code
     *
     * @return CardException
     */
    public static function factory(
        string $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $stripeCode = null
    ): CardException {
        $instance = parent::factory($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders, $stripeCode);
        $instance->setDeclineCode($declineCode);
        $instance->setBambooPaymentParam($stripeParam);

        return $instance;
    }

    /**
     * Gets the decline code.
     *
     * @return null|string
     */
    public function getDeclineCode(): ?string
    {
        return $this->declineCode;
    }

    /**
     * Sets the decline code.
     *
     * @param null|string $declineCode
     */
    public function setDeclineCode(?string $declineCode): void
    {
        $this->declineCode = $declineCode;
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
