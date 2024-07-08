<?php

namespace App\Domain\UseCases\UserSearch;

class UserSearchRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {
    }

    /**
     * Return the User Id
     * @return string
     */

    public function getUserID(): string
    {
        return $this->attributes['userId'] ?? '';
    }

    /**
     * Return the User Name
     * @return string
     */
    public function getUserName(): string
    {
        return $this->attributes['userName'] ?? '';
    }

    /**
     * Return the Company Name that the User belong
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->attributes['companyName'] ?? '';
    }

    /**
     * Return the Title of the User
     * @return string
     */
    public function getTitle(): string
    {
        return $this->attributes['title'] ?? '';
    }

    /**
     * Return the First Name of the User
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->attributes['firstName'] ?? '';
    }

    /**
     * Return the Last Name of the User
     * @return string
     */
    public function getLastName(): string
    {
        return $this->attributes['lastName'] ?? '';
    }

    /**
     * Return the Street of the User
     * @return string
     */
    public function getStreet(): string
    {
        return $this->attributes['street'] ?? '';
    }

    /**
     * Return the Zip Code of the User
     * @return int
     */
    public function getZipCode(): int
    {
        return $this->attributes['zipCode'] ?? '';
    }

    /**
     * Return the City that User belong
     * @return string
     */
    public function getCity(): string
    {
        return $this->attributes['city'] ?? '';
    }

    /**
     * Return the Country of the User
     * @return string
     */
    public function getCountry(): string
    {
        return $this->attributes['country'] ?? '';
    }

    /**
     * Return the email of the User
     * @return string
     */

    public function getEmail(): string
    {
        return $this->attributes['email'] ?? '';
    }

    /**
     * Return the Phone Number of the User
     * @return int
     */
    public function getPhone(): int
    {
        return $this->attributes['phone'] ?? '';
    }

    /**
     * Return the Phone Number of the User
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'] ?? '';
    }
}
