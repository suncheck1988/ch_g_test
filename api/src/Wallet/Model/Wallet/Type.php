<?php

declare(strict_types=1);

namespace App\Wallet\Model\Wallet;

use App\Application\ValueObject\EnumValueObject;

/**
 * @method static money()
 */
final class Type extends EnumValueObject
{
    public const MONEY = 100;

    public function isMoney(): bool
    {
        return $this->value === self::MONEY;
    }
}
