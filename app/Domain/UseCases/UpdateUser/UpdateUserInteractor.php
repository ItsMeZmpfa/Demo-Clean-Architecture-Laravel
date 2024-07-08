<?php

namespace App\Domain\UseCases\UpdateUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserFactory;
use App\Domain\Interfaces\User\UserRepository;
use App\Domain\Interfaces\ViewModel;
use App\Models\PasswordValueObject;
use App\Domain\UseCases\UpdateUser\UpdateUserInputPort;
use Illuminate\Support\Facades\Auth;

class UpdateUserInteractor implements UpdateUserInputPort
{
    public function __construct(
        private UpdateUserOutputPort $output,
        private UserRepository $repository,
        private UserFactory $factory,
    ) {
    }

    public function updateUser(UpdateUserRequestModel $request): ViewModel
    {

        try {
            $userAuth = Auth::guard('sanctum')->user();

            $user = $this->factory->updateUserPassword([
                'userId' => $userAuth->id,
                'password' => $request->getPassword(),
            ]);

            $user = $this->repository->updateUserPassword($user, new PasswordValueObject($request->getPassword()));

        } catch (\Exception $e) {
            return $this->output->unableToUpdateUser(new UpdateUserResponseModel($user), $e);
        }

        return $this->output->userUpdate(
            new UpdateUserResponseModel($user)
        );
    }
}