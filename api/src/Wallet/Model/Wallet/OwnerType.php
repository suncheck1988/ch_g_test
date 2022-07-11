<?php

declare(strict_types=1);

namespace App\Wallet\Model\Wallet;

use App\Application\ValueObject\EnumValueObject;

/**
 * @method static customer()
 */
final class OwnerType extends EnumValueObject
{
    public const CUSTOMER = 100;

    public function isCustomer(): bool
    {
        return $this->value === self::CUSTOMER;
    }
}
