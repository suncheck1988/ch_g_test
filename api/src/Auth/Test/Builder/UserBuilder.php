<?php

declare(strict_types=1);

namespace App\Auth\Test\Builder;

use App\Application\ValueObject\Uuid;
use App\Auth\Model\User\Email;
use App\Auth\Model\User\Status;
use App\Auth\Model\User\User;

final class UserBuilder
{
    private Uuid $id;
    private Email $email;
    private bool $active = false;

    public function __construct(string $email)
    {
        $this->id = Uuid::generate();
        $this->email = new Email($email);
    }

    public function withId(Uuid $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    public function withEmail(Email $email): self
    {
        $clone = clone $this;
        $clone->email = $email;
        return $clone;
    }

    public function active(): self
    {
        $clone = clone $this;
        $clone->active = true;
        return $clone;
    }

    public function build(): User
    {
        $status = Status::wait();

        if ($this->active) {
            $status = Status::active();
        }

        $user = new User(
            $this->id,
            $this->email,
            $status
        );

        return $user;
    }
}
