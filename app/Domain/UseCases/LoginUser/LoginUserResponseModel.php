<?php

namespace App\Domain\UseCases\LoginUser;

use App\Domain\Interfaces\User\UserEntity;

class LoginUserResponseModel
{
    public function __construct(private UserEntity $user, private $token) {
        //
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function getToken(): String
    {
        return $this->token;
    }
}