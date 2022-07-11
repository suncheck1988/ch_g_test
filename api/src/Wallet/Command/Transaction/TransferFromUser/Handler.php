<?php

declare(strict_types=1);

namespace App\Wallet\Command\Transaction\TransferFromUser;

use App\Application\Exception\DomainException;
use App\Application\ValueObject\Amount;
use App\Application\ValueObject\Uuid;
use App\Auth\Repository\UserRepository;
use App\Data\Flusher;
use App\Auth\Model\User\User;
use App\Wallet\Model\Transaction\Transaction;
use App\Wallet\Model\Transaction\Type;
use App\Wallet\Repository\TransactionRepository;

class Handler
{
    public function __construct(
        private UserRepository $userRepository,
        private TransactionRepository $transactionRepository,
        private Flusher $flusher
    ) {
    }

    public function handle(Command $command): void
    {
        $fromUser = $this->userRepository->get(new Uuid($command->getFromUserId()));
        $toUser = $this->userRepository->get(new Uuid($command->getToUserId()));

        if ((string)$fromUser->getId() === (string)$toUser->getId()) {
            throw new DomainException('Can not transfer for same user');
        }

        $amount = Amount::fromRub($command->getAmount());

        $transactionFrom = $this->processTransactionFrom($fromUser, $amount);
        $this->processTransactionTo($toUser, $amount, $transactionFrom);

        $this->flusher->flush();
    }

    private function processTransactionFrom(User $user, Amount $amount): Transaction
    {
        $wallet = $user->getWallet();
        if ($wallet === null) {
            throw new DomainException(sprintf('Wallet for user with id %s not found', (string)$user->getId()));
        }

        $transaction = new Transaction(
            Uuid::generate(),
            $wallet,
            new Type(Type::WITHDRAW_USER),
            $amount,
            null,
            $user
        );

        $this->transactionRepository->add($transaction);

        $transaction->confirm();

        return $transaction;
    }

    private function processTransactionTo(
        User $user,
        Amount $amount,
        Transaction $transactionFrom
    ): void {
        $wallet = $user->getWallet();
        if ($wallet === null) {
            throw new DomainException(sprintf('Wallet for user with id %s not found', (string)$user->getId()));
        }

        $transaction = new Transaction(
            Uuid::generate(),
            $wallet,
            new Type(Type::DEPOSIT_USER),
            $amount,
            $transactionFrom,
            $user
        );

        $this->transactionRepository->add($transaction);

        $transaction->confirm();
    }
}
