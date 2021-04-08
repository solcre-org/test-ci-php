<?php

namespace BambooPayment\Entity;

class Customer extends BambooPaymentObject
{
    public const OBJECT_NAME = 'customer';

    /** @var int */
    private int $CustomerId;

    /** @var  string */
    private string $Created;

    /** @var string |null */
    private ?string $CommerceCustomerId;

    /** @var string|null */
    private ?string $Owner;
    private $Commerce;

    /** @var string */
    private string $Email;

    /** @var bool|null */
    private ?bool $Enabled;

    /** @var string|null */
    private ?string $ShippingAddress;

    /** @var array|null */
    private ?array $BillingAddress;


    /** @var array|null */
    private ?array $AdditionalData;


    /** @var array|null */
    private ?array $PaymentProfiles;


    /** @var string|null */
    private ?string $CaptureURL;

    /** @var string */
    private string $UniqueID;

    /** @var string */
    private string $URL;
    private $https;

    /** @var string|null */
    private ?string $FirstName;

    /** @var string|null */
    private ?string $PrimerNombre;

    /** @var string|null */
    private ?string $LastName;

    /** @var string|null */
    private ?string $PrimerApellido;

    /** @var string|null */
    private ?string $DocNumber;

    /** @var string|null */
    private ?string $DocumentTypeId;

    /** @var string|null */
    private ?string $PhoneNumber;

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->CustomerId;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->Created;
    }

    /**
     * @return string|null
     */
    public function getCommerceCustomerId(): ?string
    {
        return $this->CommerceCustomerId;
    }

    /**
     * @return string|null
     */
    public function getOwner(): ?string
    {
        return $this->Owner;
    }

    /**
     * @return mixed
     */
    public function getCommerce()
    {
        return $this->Commerce;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->Enabled;
    }

    /**
     * @return string|null
     */
    public function getShippingAddress(): ?string
    {
        return $this->ShippingAddress;
    }

    /**
     * @return array|null
     */
    public function getBillingAddress(): ?array
    {
        return $this->BillingAddress;
    }

    /**
     * @return array|null
     */
    public function getAdditionalData(): ?array
    {
        return $this->AdditionalData;
    }

    /**
     * @return array|null
     */
    public function getPaymentProfiles(): ?array
    {
        return $this->PaymentProfiles;
    }

    /**
     * @return string|null
     */
    public function getCaptureURL(): ?string
    {
        return $this->CaptureURL;
    }

    /**
     * @return string
     */
    public function getUniqueID(): string
    {
        return $this->UniqueID;
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->URL;
    }

    /**
     * @return mixed
     */
    public function getHttps()
    {
        return $this->https;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    /**
     * @return string|null
     */
    public function getPrimerNombre(): ?string
    {
        return $this->PrimerNombre;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    /**
     * @return string|null
     */
    public function getPrimerApellido(): ?string
    {
        return $this->PrimerApellido;
    }

    /**
     * @return string|null
     */
    public function getDocNumber(): ?string
    {
        return $this->DocNumber;
    }

    /**
     * @return string|null
     */
    public function getDocumentTypeId(): ?string
    {
        return $this->DocumentTypeId;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }
}
