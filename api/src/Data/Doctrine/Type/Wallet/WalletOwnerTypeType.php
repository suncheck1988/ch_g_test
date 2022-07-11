<?php

declare(strict_types=1);

namespace App\Data\Doctrine\Type\Wallet;

use App\Data\Doctrine\Type\EnumType;
use App\Wallet\Model\Wallet\OwnerType;

class WalletOwnerTypeType extends EnumType
{
    public const NAME = 'wallet_wallet_owner_type';

    protected function getClassName(): string
    {
        return OwnerType::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
