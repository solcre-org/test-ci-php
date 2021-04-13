<?php /** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */

/** @noinspection ALL */

namespace BambooPayment\Entity;

class Customer extends BambooPaymentObject
{
    private ?int $CustomerId;
    private ?string $Created;
    private ?string $CommerceCustomerId;
    private ?string $Owner;
    private ?string $Commerce;
    private ?string $Email;
    private ?bool $Enabled;
    private ?string $ShippingAddress;
    private ?array $BillingAddress;
    private ?array $AdditionalData;
    private ?array $PaymentProfiles;
    private ?string $CaptureURL;
    private ?string $UniqueID;
    private ?string $URL;
    private ?string $https;
    private ?string $FirstName;
    private ?string $PrimerNombre;
    private ?string $LastName;
    private ?string $PrimerApellido;
    private ?string $DocNumber;
    private ?string $DocumentTypeId;
    private ?string $PhoneNumber;

    /**
     * @return int
     */
    public function getCustomerId(): ?int
    {
        return $this->CustomerId;
    }

    /**
     * @return string
     */
    public function getCreated(): ?string
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
     * @return string|null
     */
    public function getCommerce(): ?string
    {
        return $this->Commerce;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
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
    public function getUniqueID(): ?string
    {
        return $this->UniqueID;
    }

    /**
     * @return string
     */
    public function getURL(): ?string
    {
        return $this->URL;
    }

    /**
     * @return string|null
     */
    public function getHttps(): ?string
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
