<?php

namespace App\Repositories\User;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserRepository;
use App\Models\PasswordValueObject;
use App\Models\User;
use Illuminate\Support\Collection;

class UserDatabaseRepository implements UserRepository
{
    public function findUserbyEmail(UserEntity $user): UserEntity
    {
        return User::where('email', $user->getUserEmail())->first();
    }

    public function findUserbyId(UserEntity $user): UserEntity
    {
        return User::create([
            'name' => $user->getUserName(),
            'email' => $user->getUserEmail(),
        ]);
    }

    public function create(UserEntity $user, PasswordValueObject $password): UserEntity
    {
        return User::create([
            'name' => $user->getUserName(),
            'email' => $user->getUserEmail(),
            'password' => $password,
        ]);
    }

    public function findUserbySearchCredential(array $searchCredential): Collection
    {


        $records = User::when($searchCredential['userId'], function ($query, $userId) {
            return $query->where('id', $userId);

        })->when($searchCredential['name'], function ($query, $userName) {
            return $query->where('name', $userName);

        })->when($searchCredential['email'], function ($query, $userEmail) {
            return $query->where('email', $userEmail);

        })->get();

        return $records;
    }

    public function updateUserPassword(UserEntity $user, PasswordValueObject $password): bool
    {
        return User::where([
            'id' => $user->getUserId(),
        ])->update([
            'password' => $password,
        ]);


    }

    public function existsbyId(UserEntity $user): bool
    {

        return User::where([
            'id' => $user->getUserId(),
        ])->exists();
    }

    public function exists(UserEntity $user): bool
    {
        return User::where([
            'email' => $user->getUserEmail(),
        ])->exists();
    }
}
