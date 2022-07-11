<?php

declare(strict_types=1);

namespace App\Wallet\Model\Transaction;

use App\Application\ValueObject\EnumValueObject;

/**
 * @method static new()
 * @method static confirmed()
 */
final class Status extends EnumValueObject
{
    public const NEW = 100;
    public const CONFIRMED = 200;

    public function isNew(): bool
    {
        return $this->value === self::NEW;
    }

    public function isConfirmed(): bool
    {
        return $this->value === self::CONFIRMED;
    }
}
