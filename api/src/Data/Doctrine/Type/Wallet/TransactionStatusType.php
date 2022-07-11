<?php

declare(strict_types=1);

namespace App\Data\Doctrine\Type\Wallet;

use App\Data\Doctrine\Type\EnumType;
use App\Wallet\Model\Transaction\Status;

class TransactionStatusType extends EnumType
{
    public const NAME = 'wallet_transaction_status';

    protected function getClassName(): string
    {
        return Status::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
