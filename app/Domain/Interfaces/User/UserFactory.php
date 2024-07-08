<?php

namespace App\Domain\Interfaces\User;

interface UserFactory
{
    /**
     * Create a Factory Object for new User
     *
     * @param array<mixed> $attributes
     * @return UserEntity
     */
    public function makeUser(array $attributes = []): UserEntity;

    /**
     * Create a Factory Object for Delete a User
     *
     * @param array<mixed> $attributes
     * @return UserEntity
     */
    public function deleteUser(array $attributes = []): UserEntity;

    /**
     * Create a Factory Object for Search Credential a User
     *
     * @param array<mixed> $attributes
     * @return UserEntity
     */
    public function searchCredentialUser(array $attributes = []): array;

        /**
     * Create a Factory Object for new User
     *
     * @param array<mixed> $attributes
     * @return UserEntity
     */
    public function updateUserPassword(array $attributes = []): UserEntity;

}
