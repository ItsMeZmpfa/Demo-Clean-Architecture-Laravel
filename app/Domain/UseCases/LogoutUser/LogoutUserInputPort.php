<?php

namespace App\Domain\UseCases\LogoutUser;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\LogoutUser\LogoutUserRequestModel;

interface LogoutUserInputPort
{
    public function logoutUser(LogoutUserRequestModel $model): ViewModel;
}