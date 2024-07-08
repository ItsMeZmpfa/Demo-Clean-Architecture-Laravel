<?php

namespace App\Factories\User;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserFactory;
use App\Models\EmailValueObject;
use App\Models\PasswordValueObject;
use App\Models\User;
use Illuminate\Support\Collection;

class UserModelFactory implements UserFactory
{
    public function makeUser(array $attributes = []): UserEntity
    {
        if (isset($attributes['email']) && is_string($attributes['email'])) {
            $attributes['email'] = new EmailValueObject($attributes['email']);
        }

        if (isset($attributes['password']) && is_string($attributes['password'])) {
            $attributes['password'] = new PasswordValueObject($attributes['password']);
        }
        
        return new User($attributes);
    }

    public function deleteUser(array $attributes = []): UserEntity
    {
        
        return new User($attributes);
    }
   
    public function searchCredentialUser(array $attributes = []): array
    {
        
        return $attributes;
    }

        public function updateUserPassword(array $attributes = []): UserEntity
    {
                if (isset($attributes['password']) && is_string($attributes['password'])) {
            $attributes['password'] = new PasswordValueObject($attributes['password']);
        }

       return new User($attributes);
    }
}
