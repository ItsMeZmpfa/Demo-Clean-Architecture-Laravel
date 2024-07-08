<?php

namespace App\Domain\UseCases\UserSearch;

use Illuminate\Support\Collection;

class UserSearchResponseModel
{
    public function __construct(
        private Collection $userRecords
    ) {
    }

    /**
     * Return the Model of the User in a Collection
     * @return Collection
     */
    public function getUserRecord(): Collection
    {
        return $this->userRecords;
    }
}
