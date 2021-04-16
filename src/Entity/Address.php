<?php

/** @noinspection ALL */

namespace BambooPayment\Entity;


/**
 * Class Address
 * Adress of a customer
 * @package BambooPayment\Entity
 */
class Address extends BambooPaymentObject
{
    /** @var int */
    private $AddressId;
    /** @var int|null */
    private $AddressType;
    /** @var string|null */
    private $Country;
    /** @var string|null */
    private $State;
    /** @var string */
    private $AddressDetail;
    /** @var string|null */
    private $PostalCode;
    /** @var string|null */
    private $City;

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->AddressId;
    }

    /**
     * @param int $AddressId
     */
    public function setAddressId(int $AddressId): void
    {
        $this->AddressId = $AddressId;
    }

    /**
     * @return int|null
     */
    public function getAddressType(): ?int
    {
        return $this->AddressType;
    }

    /**
     * @param int|null $AddressType
     */
    public function setAddressType(?int $AddressType): void
    {
        $this->AddressType = $AddressType;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->Country;
    }

    /**
     * @param string|null $Country
     */
    public function setCountry(?string $Country): void
    {
        $this->Country = $Country;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->State;
    }

    /**
     * @param string|null $State
     */
    public function setState(?string $State): void
    {
        $this->State = $State;
    }

    /**
     * @return string
     */
    public function getAddressDetail(): string
    {
        return $this->AddressDetail;
    }

    /**
     * @param string $AddressDetail
     */
    public function setAddressDetail(string $AddressDetail): void
    {
        $this->AddressDetail = $AddressDetail;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    /**
     * @param string|null $PostalCode
     */
    public function setPostalCode(?string $PostalCode): void
    {
        $this->PostalCode = $PostalCode;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string|null $City
     */
    public function setCity(?string $City): void
    {
        $this->City = $City;
    }
}
