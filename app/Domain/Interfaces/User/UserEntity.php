<?php

namespace App\Domain\Interfaces\User;

use App\Models\EmailValueObject;
use App\Models\HashedPasswordValueObject;
use App\Models\PasswordValueObject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface UserEntity
{

    /**
     * Get the Id of the user
     * @return int
     */
    public function getUserId(): int;

    /**
     * Get the Name of the user
     * @return int
     */
    public function getUserName(): string;

    /**
     * Get the first name of the user
     * @return string
     */
    public function getUserFirstName(): string;

    /**
     * set the first name of the user
     * @param  string  $userName
     * @return void
     */
    public function setUserFirstName(string $userFirstName): void;

    /**
     * Get the last name of the user
     * @return string
     */
    public function getUserLastName(): string;

    /**
     * set the last name of the user
     * @param  string  $userLastName
     * @return void
     */
    public function setUserLastName(string $userLastName): void;

    /**
     * Get the email of the user
     * @return EmailValueObject
     */
    public function getUserEmail(): EmailValueObject;

    /**
     * set the email of the user
     * @param  string  $userEmail
     * @return void
     */
    public function setUserEmail(EmailValueObject $email): void;

    /**
     * Get the password of the user
     * @return HashedPasswordValueObject
     */
    public function getUserPassword(): HashedPasswordValueObject;

    /**
     * set the password of the user
     * @param  PasswordValueObject  $userUserUserPassword
     * @return void
     */
    public function setUserPassword(PasswordValueObject $userUserUserPassword): void;

    /**
     * The schedule that belong to the User
     *
     * @return BelongsToMany
     */
    public function schedule(): BelongsToMany;
}
