<?php

declare(strict_types=1);

namespace App\Wallet\Command\Transaction\TransferFromUser;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class Command
{
    public function __construct(
        #[NotBlank]
        private string $fromUserId,
        #[NotBlank]
        private string $toUserId,
        #[Positive]
        private float $amount
    ) {
    }

    public function getFromUserId(): string
    {
        return $this->fromUserId;
    }

    public function getToUserId(): string
    {
        return $this->toUserId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
