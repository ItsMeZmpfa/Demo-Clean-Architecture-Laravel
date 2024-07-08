<?php

namespace App\Domain\UseCases\LogoutUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserFactory;
use App\Domain\Interfaces\User\UserRepository;
use App\Domain\Interfaces\ViewModel;
use App\Models\PasswordValueObject;
use App\Domain\UseCases\LogoutUser\LogoutUserInputPort;
use Illuminate\Support\Facades\Auth;

class LogoutUserInteractor implements LogoutUserInputPort
{
    public function __construct(
        private LogoutUserOutputPort $output,
        private UserRepository $repository,
        private UserFactory $factory,
    ) {
    }

    public function logoutUser(LogoutUserRequestModel $request): ViewModel
    {
        $user = Auth::guard('sanctum')->user();

        try {
            $user->tokens()->delete();

        } catch (\Exception $e) {
            return $this->output->unableToLogoutUser(new LogoutUserResponseModel($user), $e);
        }

        return $this->output->userLogout(
            new LogoutUserResponseModel()
        );
    }
}