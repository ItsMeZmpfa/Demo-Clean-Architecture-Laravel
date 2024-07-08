<?php

namespace App\Domain\UseCases\LoginUser;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\LoginUser\LoginUserRequestModel;

interface LoginUserInputPort
{
    public function loginUser(LoginUserRequestModel $model): ViewModel;
}