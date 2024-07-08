<?php

namespace App\Domain\UseCases\UpdateUser;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UpdateUser\UpdateUserRequestModel;

interface UpdateUserInputPort
{
    public function updateUser(UpdateUserRequestModel $model): ViewModel;
}