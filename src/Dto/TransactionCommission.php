<?php

declare(strict_types=1);

namespace CommissionTask\Dto;

class TransactionCommission
{
    private string $amount;
    private string $currencyCode;
    private int $customerId;
    private string $customerType;
    private string $transactionType;
    private string $createdAt;

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     *
     * @return TransactionCommission
     */
    public function setAmount(string $amount): TransactionCommission
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     *
     * @return TransactionCommission
     */
    public function setCurrencyCode(string $currencyCode): TransactionCommission
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     *
     * @return TransactionCommission
     */
    public function setCustomerId(int $customerId): TransactionCommission
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerType(): int
    {
        return $this->customerType;
    }

    /**
     * @param string $customerType
     *
     * @return TransactionCommission
     */
    public function setCustomerType(string $customerType): TransactionCommission
    {
        $this->customerType = $customerType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    /**
     * @param string $transactionType
     *
     * @return TransactionCommission
     */
    public function setTransactionType(string $transactionType): TransactionCommission
    {
        $this->TransactionType = $transactionType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     *
     * @return TransactionCommission
     */
    public function setCreatedAt(string $createdAt): TransactionCommission
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}