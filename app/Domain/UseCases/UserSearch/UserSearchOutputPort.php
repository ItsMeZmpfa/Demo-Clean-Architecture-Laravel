<?php

namespace App\Domain\UseCases\UserSearch;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UserSearch\UserSearchResponseModel;

interface UserSearchOutputPort
{
    public function userSearch(UserSearchResponseModel $model): ViewModel;

    public function unableToUserSearch(UserSearchResponseModel $model, \Throwable $e): ViewModel;
}
