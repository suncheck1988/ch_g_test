<?php

declare(strict_types=1);

namespace Test\Functional\V1\Auth\User;

use App\Application\ValueObject\Amount;
use App\Application\ValueObject\Uuid;
use App\Auth\Test\Builder\UserBuilder;
use App\Wallet\Model\Wallet\OwnerType;
use App\Wallet\Model\Wallet\Type;
use App\Wallet\Model\Wallet\Wallet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

final class UsersFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = (new UserBuilder('mail1@example.com'))
            ->withId(new Uuid('00000000-0000-0000-0000-000000000001'))
            ->active()
            ->build();

        $wallet1 = new Wallet(
            new Uuid('00000000-0000-0000-0000-000000000001'),
            OwnerType::customer(),
            $user1,
            Type::money()
        );
        $wallet1->incrementBalance(new Amount(500));

        $user1->addWallet($wallet1);

        $manager->persist($user1);

        $user2 = (new UserBuilder('mail2@example.com'))
            ->withId(new Uuid('00000000-0000-0000-0000-000000000002'))
            ->active()
            ->build();

        $wallet2 = new Wallet(
            new Uuid('00000000-0000-0000-0000-000000000002'),
            OwnerType::customer(),
            $user2,
            Type::money()
        );
        $wallet2->incrementBalance(new Amount(500));

        $user2->addWallet($wallet2);

        $manager->persist($user2);

        $manager->flush();
    }
}
