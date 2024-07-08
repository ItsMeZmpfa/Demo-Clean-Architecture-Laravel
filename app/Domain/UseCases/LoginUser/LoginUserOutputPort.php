<?php

namespace App\Domain\UseCases\LoginUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\LoginUser\LoginUserResponseModel;

interface LoginUserOutputPort
{
    public function userLogin(LoginUserResponseModel $model): ViewModel;
    
    public function unableToLogin(LoginUserResponseModel $model, \Throwable $e): ViewModel;
    
    public function unableToLoginUser(LoginUserResponseModel $model): ViewModel;
}