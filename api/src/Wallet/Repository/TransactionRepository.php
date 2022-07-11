<?php

declare(strict_types=1);

namespace App\Wallet\Repository;

use App\Application\Repository\AbstractRepository;
use App\Wallet\Model\Transaction\Transaction;

final class TransactionRepository extends AbstractRepository
{
    public function add(Transaction $transaction): void
    {
        $this->entityManager->persist($transaction);
    }

    protected function getModelClassName(): string
    {
        return Transaction::class;
    }
}
