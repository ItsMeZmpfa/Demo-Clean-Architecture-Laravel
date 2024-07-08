<?php

namespace App\Domain\UseCases\UpdateUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UpdateUser\UpdateUserResponseModel;

interface UpdateUserOutputPort
{
    public function userUpdate(UpdateUserResponseModel $model): ViewModel;

    public function unableToUpdateUser(UpdateUserResponseModel $model, \Throwable $e): ViewModel;
}