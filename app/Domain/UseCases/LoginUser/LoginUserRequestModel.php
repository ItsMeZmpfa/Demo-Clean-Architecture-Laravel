<?php

namespace App\Domain\UseCases\LoginUser;

class LoginUserRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(private array $attributes) {
        //
    }

    public function getEmail(): string
    {
        return $this->attributes['email'] ?? '';
    }

    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }

    
}