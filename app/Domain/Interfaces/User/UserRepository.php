<?php

namespace App\Domain\Interfaces\User;

use App\Models\PasswordValueObject;
use Illuminate\Support\Collection;

interface UserRepository
{
    /**
     * Check if the given User exists in Database
     *
     * @param  UserEntity  $user
     * @return bool
     */
    public function exists(UserEntity $user): bool;

    /**
     * Check if the given User exists in Database
     *
     * @param  UserEntity  $user
     * @return bool
     */
    public function existsbyId(UserEntity $user): bool;

    /**
     * Create a new User entry in the Database
     *
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function create(UserEntity $user, PasswordValueObject $password): UserEntity;

    /**
     * Find a User by a given Id
     *
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function findUserbyId(UserEntity $user): UserEntity;


    /**
     * Find a User by a Email
     *
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function findUserbyEmail(UserEntity $user): UserEntity;

    /**
     * Find a User by a specefic Search Credentail
     *
     * @param  UserEntity  $user
     * @return Collection
     */
    public function findUserbySearchCredential(array $searchCredential): Collection;

    /**
     * Update the User Password by a given Id
     *
     * @param  UserEntity  $user
     * @return bool
     */
    public function updateUserPassword(UserEntity $user, PasswordValueObject $password): bool;
}
