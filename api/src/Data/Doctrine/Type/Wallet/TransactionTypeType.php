<?php

declare(strict_types=1);

namespace App\Data\Doctrine\Type\Wallet;

use App\Data\Doctrine\Type\EnumType;
use App\Wallet\Model\Transaction\Type;

class TransactionTypeType extends EnumType
{
    public const NAME = 'wallet_transaction_type';

    protected function getClassName(): string
    {
        return Type::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
