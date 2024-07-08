<?php

namespace App\Domain\UseCases\UpdateUser;

use App\Domain\Interfaces\User\UserEntity;

class UpdateUserResponseModel
{
    public function __construct(
        private bool $user
    ) {
    }

    public function getUser(): bool
    {
        return $this->user;
    }
}