<?php

/** @noinspection ALL */

namespace BambooPayment\Entity;

class Purchase extends BambooPaymentObject
{
    private ?int $PurchaseId;
    private ?string $Created;
    private ?string $TrxToken;
    private int $Order;
    private array $Transaction;
    private bool $Capture;
    private int $Amount;
    private int $OriginalAmount;
    private int $TaxableAmount;
    private int $Tip;
    private int $Installments;
    private ?string $Currency;
    private ?string $Description;
    private ?array $Customer;
    private ?string $RefundList;
    private ?string $PlanID;
    private ?string $UniqueID;
    private ?string $AdditionalData;
    private ?string $CustomerUserAgent;
    private ?string $CustomerIP;
    private ?string $URL;
    private ?array $DataUY;
    private ?string $DataDO;
    private ?array $Acquirer;
    private ?string $CommerceAction;
    private int $PurchasePaymentProfileId;
    private ?string $LoyaltyPlan;
    private ?string $DeviceFingerprintId;

    /**
     * @return int|null
     */
    public function getPurchaseId(): ?int
    {
        return $this->PurchaseId;
    }

    /**
     * @return string|null
     */
    public function getCreated(): ?string
    {
        return $this->Created;
    }

    /**
     * @return string|null
     */
    public function getTrxToken(): ?string
    {
        return $this->TrxToken;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->Order;
    }

    /**
     * @return array
     */
    public function getTransaction(): array
    {
        return $this->Transaction;
    }

    /**
     * @return bool
     */
    public function isCapture(): bool
    {
        return $this->Capture;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->Amount;
    }

    /**
     * @return int
     */
    public function getOriginalAmount(): int
    {
        return $this->OriginalAmount;
    }

    /**
     * @return int
     */
    public function getTaxableAmount(): int
    {
        return $this->TaxableAmount;
    }

    /**
     * @return int
     */
    public function getTip(): int
    {
        return $this->Tip;
    }

    /**
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->Installments;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->Description;
    }

    /**
     * @return array|null
     */
    public function getCustomer(): ?array
    {
        return $this->Customer;
    }

    /**
     * @return string|null
     */
    public function getRefundList(): ?string
    {
        return $this->RefundList;
    }

    /**
     * @return string|null
     */
    public function getPlanID(): ?string
    {
        return $this->PlanID;
    }

    /**
     * @return string|null
     */
    public function getUniqueID(): ?string
    {
        return $this->UniqueID;
    }

    /**
     * @return string|null
     */
    public function getAdditionalData(): ?string
    {
        return $this->AdditionalData;
    }

    /**
     * @return string|null
     */
    public function getCustomerUserAgent(): ?string
    {
        return $this->CustomerUserAgent;
    }

    /**
     * @return string|null
     */
    public function getCustomerIP(): ?string
    {
        return $this->CustomerIP;
    }

    /**
     * @return string|null
     */
    public function getURL(): ?string
    {
        return $this->URL;
    }

    /**
     * @return array|null
     */
    public function getDataUY(): ?array
    {
        return $this->DataUY;
    }

    /**
     * @return string|null
     */
    public function getDataDO(): ?string
    {
        return $this->DataDO;
    }

    /**
     * @return array|null
     */
    public function getAcquirer(): ?array
    {
        return $this->Acquirer;
    }

    /**
     * @return string|null
     */
    public function getCommerceAction(): ?string
    {
        return $this->CommerceAction;
    }

    /**
     * @return int
     */
    public function getPurchasePaymentProfileId(): int
    {
        return $this->PurchasePaymentProfileId;
    }

    /**
     * @return string|null
     */
    public function getLoyaltyPlan(): ?string
    {
        return $this->LoyaltyPlan;
    }

    /**
     * @return string|null
     */
    public function getDeviceFingerprintId(): ?string
    {
        return $this->DeviceFingerprintId;
    }
}
