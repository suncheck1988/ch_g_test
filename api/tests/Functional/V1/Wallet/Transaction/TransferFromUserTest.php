<?php

declare(strict_types=1);

namespace Test\Functional\V1\Wallet\Transaction;

use Test\Functional\Json;
use Test\Functional\V1\Auth\User\UsersFixture;
use Test\Functional\WebTestCase;

/**
 * @internal
 */
final class TransferFromUserTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            UsersFixture::class,
        ]);
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/V1/transaction/transfer-from-user', [
            'fromUserId' => '00000000-0000-0000-0000-000000000001',
            'toUserId' => '00000000-0000-0000-0000-000000000002',
            'amount' => 4.0,
        ]));

        self::assertEquals(204, $response->getStatusCode());
        self::assertEquals('', (string)$response->getBody());
    }

    /**
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedArrayAccess
     */
    public function testNegative(): void
    {
        $response = $this->app()->handle(self::json('POST', '/V1/transaction/transfer-from-user', [
            'fromUserId' => '00000000-0000-0000-0000-000000000001',
            'toUserId' => '00000000-0000-0000-0000-000000000002',
            'amount' => 6.0,
        ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertContains(
            'Balance < 0',
            Json::decode($body)['errors'][0]
        );
    }
}
