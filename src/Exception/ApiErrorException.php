<?php

namespace BambooPayment\Exception;

use BambooPayment\ErrorObject;
use BambooPayment\Util\CaseInsensitiveArray;
use Exception;
use function array_key_exists;

/**
 * Implements properties and methods common to all (non-SPL) BambooPayment exceptions.
 */
abstract class ApiErrorException extends Exception implements ExceptionInterface
{
    protected ?ErrorObject $error;
    protected ?string $httpBody;
    protected $httpHeaders;
    protected ?int $httpStatus;
    protected ?array $jsonBody;
    protected ?string $requestId;
    protected $stripeCode;

    /**
     * Creates a new API error exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $stripeCode the BambooPayment error code
     *
     * @return static
     */
    public static function factory(
        string $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $stripeCode = null
    ): ApiErrorException {
        $instance = new static($message);
        $instance->setHttpStatus($httpStatus);
        $instance->setHttpBody($httpBody);
        $instance->setJsonBody($jsonBody);
        $instance->setHttpHeaders($httpHeaders);
        $instance->setBambooPaymentCode($stripeCode);

        $instance->setRequestId(null);
        if ($httpHeaders && isset($httpHeaders['Request-Id'])) {
            $instance->setRequestId($httpHeaders['Request-Id']);
        }

//        $instance->setError($instance->constructErrorObject());
        $instance->setError(null);

        return $instance;
    }

    /**
     * Gets the BambooPayment error object.
     *
     * @return null|ErrorObject
     */
    public function getError(): ?ErrorObject
    {
        return $this->error;
    }

    /**
     * Sets the BambooPayment error object.
     *
     * @param null|ErrorObject $error
     */
    public function setError(?ErrorObject $error): void
    {
        $this->error = $error;
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
     * Gets the HTTP headers array.
     *
     * @return null|array|CaseInsensitiveArray
     */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    /**
     * Sets the HTTP headers array.
     *
     * @param null|array|CaseInsensitiveArray $httpHeaders
     */
    public function setHttpHeaders($httpHeaders): void
    {
        $this->httpHeaders = $httpHeaders;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return null|int
     */
    public function getHttpStatus(): ?int
    {
        return $this->httpStatus;
    }

    /**
     * Sets the HTTP status code.
     *
     * @param null|int $httpStatus
     */
    public function setHttpStatus(?int $httpStatus): void
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * Gets the JSON deserialized body.
     *
     * @return null|array<string, mixed>
     */
    public function getJsonBody(): ?array
    {
        return $this->jsonBody;
    }

    /**
     * Sets the JSON deserialized body.
     *
     * @param null|array<string, mixed> $jsonBody
     */
    public function setJsonBody(?array $jsonBody): void
    {
        $this->jsonBody = $jsonBody;
    }

    /**
     * Gets the BambooPayment request ID.
     *
     * @return null|string
     */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * Sets the BambooPayment request ID.
     *
     * @param null|string $requestId
     */
    public function setRequestId(?string $requestId): void
    {
        $this->requestId = $requestId;
    }

    /**
     * Gets the BambooPayment error code.
     *
     * Cf. the `CODE_*` constants on {@see \BambooPayment\ErrorObject} for possible
     * values.
     *
     * @return null|string
     */
    public function getBambooPaymentCode(): ?string
    {
        return $this->stripeCode;
    }

    /**
     * Sets the BambooPayment error code.
     *
     * @param null|string $stripeCode
     */
    public function setBambooPaymentCode(?string $stripeCode): void
    {
        $this->stripeCode = $stripeCode;
    }

    /**
     * Returns the string representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        $statusStr = ($this->getHttpStatus() === null) ? '' : "(Status {$this->getHttpStatus()}) ";
        $idStr = ($this->getRequestId() === null) ? '' : "(Request {$this->getRequestId()}) ";

        return "{$statusStr}{$idStr}{$this->getMessage()}";
    }

    protected function constructErrorObject(): void
    {
        if ($this->jsonBody === null || ! array_key_exists('error', $this->jsonBody)) {
//            return null;
        }

//        return ErrorObject::constructFrom($this->jsonBody['error']);
    }
}
