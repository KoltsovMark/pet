<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

use CommissionTask\Dto\NewTransaction as NewTransactionDto;
use CommissionTask\Model\Transaction as TransactionModel;

class Transaction
{
    public function createEmpty(): TransactionModel
    {
        return new TransactionModel();
    }

    /**
     * @throws \Exception
     */
    public function createFromNewTransactionDto(NewTransactionDto $newTransactionDto): TransactionModel
    {
        $transaction = $this->createEmpty();

        $transaction->setCreatedAt(new \DateTime($newTransactionDto->getCreatedAt()))
            ->setType($newTransactionDto->getTransactionType())
            ->setAmount($newTransactionDto->getAmount())
        ;

        return $transaction;
    }
}
