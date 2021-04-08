<?php

namespace BambooPayment\Exception;

use Exception;

/**
 * SignatureVerificationException is thrown when the signature verification for
 * a webhook fails.
 */
class SignatureVerificationException extends Exception implements ExceptionInterface
{
    protected ?string $httpBody;
    protected ?string $sigHeader;

    /**
     * Creates a new SignatureVerificationException exception.
     *
     * @param string $message the exception message
     * @param null|string $httpBody the HTTP body as a string
     * @param null|string $sigHeader the `BambooPayment-Signature` HTTP header
     *
     * @return SignatureVerificationException
     */
    public static function factory(
        string $message,
        $httpBody = null,
        $sigHeader = null
    ): SignatureVerificationException {
        $instance = new static($message);
        $instance->setHttpBody($httpBody);
        $instance->setSigHeader($sigHeader);

        return $instance;
    }

    /**
     * Gets the HTTP body as a string.
     *
     * @return null|string
     */
    public function getHttpBody(): ?string
    {
        return $this->httpBody;
    }

    /**
     * Sets the HTTP body as a string.
     *
     * @param null|string $httpBody
     */
    public function setHttpBody(?string $httpBody): void
    {
        $this->httpBody = $httpBody;
    }

    /**
     * Gets the `BambooPayment-Signature` HTTP header.
     *
     * @return null|string
     */
    public function getSigHeader(): ?string
    {
        return $this->sigHeader;
    }

    /**
     * Sets the `BambooPayment-Signature` HTTP header.
     *
     * @param null|string $sigHeader
     */
    public function setSigHeader(?string $sigHeader): void
    {
        $this->sigHeader = $sigHeader;
    }
}
