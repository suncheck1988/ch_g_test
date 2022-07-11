<?php

declare(strict_types=1);

namespace App\Wallet\Model\Transaction;

use App\Application\ValueObject\EnumValueObject;

/**
 * @method static deposit_user()
 * @method static withdraw_user()
 */
final class Type extends EnumValueObject
{
    public const DEPOSIT_USER = 100;
    public const WITHDRAW_USER = 200;

    public function isDepositUser(): bool
    {
        return $this->value === self::DEPOSIT_USER;
    }

    public function isWithdrawUser(): bool
    {
        return $this->value === self::WITHDRAW_USER;
    }
}
