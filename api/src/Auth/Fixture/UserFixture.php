<?php

declare(strict_types=1);

namespace App\Auth\Fixture;

use App\Application\ValueObject\Amount;
use App\Application\ValueObject\Uuid;
use App\Auth\Model\User\Email;
use App\Auth\Model\User\Status;
use App\Auth\Model\User\User;
use App\Wallet\Model\Wallet\OwnerType;
use App\Wallet\Model\Wallet\Type;
use App\Wallet\Model\Wallet\Wallet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User(
            new Uuid('00000000-0000-0000-0000-000000000001'),
            new Email('user1@app.test'),
            Status::active()
        );

        $user1Wallet = new Wallet(
            new Uuid('00000000-0000-0000-0000-000000000001'),
            OwnerType::customer(),
            $user1,
            Type::money()
        );
        $user1Wallet->incrementBalance(new Amount(500));

        $user1->addWallet($user1Wallet);

        $manager->persist($user1);

        $user2 = new User(
            new Uuid('00000000-0000-0000-0000-000000000002'),
            new Email('user2@app.test'),
            Status::active()
        );

        $user2Wallet = new Wallet(
            new Uuid('00000000-0000-0000-0000-000000000002'),
            OwnerType::customer(),
            $user2,
            Type::money()
        );
        $user2Wallet->incrementBalance(new Amount(500));

        $user2->addWallet($user2Wallet);

        $manager->persist($user2);

        $manager->flush();
    }
}
