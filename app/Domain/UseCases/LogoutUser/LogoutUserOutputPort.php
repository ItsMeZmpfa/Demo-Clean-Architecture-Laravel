<?php

namespace App\Domain\UseCases\LogoutUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\LogoutUser\LogoutUserResponseModel;

interface LogoutUserOutputPort
{
    public function userLogout(LogoutUserResponseModel $model): ViewModel;

    public function unableToLogoutUser(LogoutUserResponseModel $model, \Throwable $e): ViewModel;
}