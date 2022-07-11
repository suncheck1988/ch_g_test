<?php

declare(strict_types=1);

namespace App\Wallet\Model\Wallet;

use App\Application\Exception\DomainException;
use App\Application\Model\IdentifiableTrait;
use App\Application\Model\TimestampableTrait;
use App\Application\ValueObject\Amount;
use App\Application\ValueObject\Uuid;
use App\Auth\Model\User\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wallet')]
class Wallet
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(type: 'wallet_wallet_owner_type')]
    private OwnerType $ownerType;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'wallet')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;

    #[ORM\Column(type: 'wallet_wallet_type')]
    private Type $type;

    #[ORM\Column(type: 'amount', length: 20)]
    private Amount $balance;

    public function __construct(
        Uuid $id,
        OwnerType $ownerType,
        User $user,
        Type $type
    ) {
        $this->id = $id;
        $this->ownerType = $ownerType;
        $this->user = $user;
        $this->type = $type;
        $this->balance = new Amount(0);
        $this->createdAt = new DateTimeImmutable();
    }

    public function incrementBalance(Amount $amount): void
    {
        $this->balance = new Amount(
            $this->balance->getValue() + $amount->getValue()
        );
        $this->updatedAt = new DateTimeImmutable();
    }

    public function decrementBalance(Amount $amount): void
    {
        if ($this->balance->getValue() < $amount->getValue()) {
            throw new DomainException('Balance < 0');
        }

        $this->balance = new Amount(
            $this->balance->getValue() - $amount->getValue()
        );
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getOwnerType(): OwnerType
    {
        return $this->ownerType;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getBalance(): Amount
    {
        return $this->balance;
    }
}
