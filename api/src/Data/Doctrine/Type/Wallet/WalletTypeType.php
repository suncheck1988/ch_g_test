<?php

declare(strict_types=1);

namespace App\Data\Doctrine\Type\Wallet;

use App\Data\Doctrine\Type\EnumType;
use App\Wallet\Model\Wallet\Type;

class WalletTypeType extends EnumType
{
    public const NAME = 'wallet_wallet_type';

    protected function getClassName(): string
    {
        return Type::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
