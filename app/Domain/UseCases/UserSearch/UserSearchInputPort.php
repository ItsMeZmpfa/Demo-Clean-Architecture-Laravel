<?php

namespace App\Domain\UseCases\UserSearch;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UserSearch\UserSearchRequestModel;

interface UserSearchInputPort
{
    public function searchUser(UserSearchRequestModel $model): ViewModel;
}
