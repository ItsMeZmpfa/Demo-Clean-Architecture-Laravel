<?php

namespace App\Domain\UseCases\LogoutUser;

class LogoutUserRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(private array $attributes)
    {

    }

}