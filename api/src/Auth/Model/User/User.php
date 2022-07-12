<?php

declare(strict_types=1);

namespace App\Auth\Model\User;

use App\Application\Model\IdentifiableTrait;
use App\Application\Model\TimestampableTrait;
use App\Application\ValueObject\Uuid;
use App\Wallet\Model\Wallet\Wallet;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '"user"')]
class User
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(type: 'auth_user_email', unique: true)]
    private Email $email;

    #[ORM\Column(type: 'auth_user_status')]
    private Status $status;

    #[ORM\Column(type: 'auth_user_role')]
    private Role $role;

    #[ORM\OneToOne(targetEntity: Wallet::class, mappedBy: 'user', cascade: ['all'], orphanRemoval: true)]
    private ?Wallet $wallet = null;

    public function __construct(
        Uuid $id,
        Email $email,
        Status $status
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->status = $status;
        $this->role = Role::user();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function addWallet(?Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }
}
