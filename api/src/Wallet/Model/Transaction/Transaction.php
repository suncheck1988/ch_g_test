<?php

declare(strict_types=1);

namespace App\Wallet\Model\Transaction;

use App\Application\Exception\InvalidStatusTransitionException;
use App\Application\Model\IdentifiableTrait;
use App\Application\Model\TimestampableTrait;
use App\Application\ValueObject\Amount;
use App\Application\ValueObject\Uuid;
use App\Auth\Model\User\User;
use App\Wallet\Model\Wallet\Wallet;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

#[ORM\Entity]
#[ORM\Table(name: 'transaction')]
class Transaction
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\ManyToOne(targetEntity: Wallet::class)]
    #[ORM\JoinColumn(name: 'wallet_id', referencedColumnName: 'id', nullable: false)]
    private Wallet $wallet;

    #[ORM\Column(type: 'wallet_transaction_type')]
    private Type $type;

    #[ORM\Column(type: 'amount', length: 20)]
    private Amount $amount;

    #[ORM\Column(type: 'wallet_transaction_status')]
    private Status $status;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $confirmedAt = null;

    #[ORM\OneToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'transaction_id', referencedColumnName: 'id', nullable: true)]
    private ?Transaction $transaction;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: 'id', nullable: false)]
    private User $createdBy;

    public function __construct(
        Uuid $id,
        Wallet $wallet,
        Type $type,
        Amount $amount,
        ?self $transaction,
        User $createdBy
    ) {
        $this->id = $id;
        $this->wallet = $wallet;
        $this->type = $type;
        $this->amount = $amount;
        $this->status = Status::new();
        $this->transaction = $transaction;
        $this->createdBy = $createdBy;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @throws InvalidStatusTransitionException
     */
    public function confirm(): self
    {
        if (!$this->status->isNew()) {
            throw new InvalidStatusTransitionException(sprintf('Transaction %s is already confirmed', $this->getId()->getValue()));
        }

        $this->status = Status::confirmed();
        $this->recalculateWalletBalance();
        $this->confirmedAt = new DateTimeImmutable();

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getConfirmedAt(): ?DateTimeImmutable
    {
        return $this->confirmedAt;
    }

    public function getUser(): User
    {
        return $this->createdBy;
    }

    public function getTransaction(): ?self
    {
        return $this->transaction;
    }

    private function recalculateWalletBalance(): void
    {
        if ($this->status->isNew()) {
            throw new LogicException(sprintf('Transaction %s is in incorrect status', $this->getId()->getValue()));
        }

        switch ($this->getType()->getValue()) {
            case Type::DEPOSIT_USER:
                $this->wallet->incrementBalance($this->amount);
                break;
            case Type::WITHDRAW_USER:
                $this->wallet->decrementBalance($this->amount);
                break;
        }
    }
}
