<?php

namespace App\Domain\UseCases\CreateUser;

use App\Domain\Interfaces\User\UserEntity;
use App\Domain\Interfaces\User\UserFactory;
use App\Domain\Interfaces\User\UserRepository;
use App\Domain\Interfaces\ViewModel;
use App\Models\PasswordValueObject;
use App\Domain\UseCases\CreateUser\CreateUserInputPort;
use Illuminate\Support\Facades\Log;

class CreateUserInteractor implements CreateUserInputPort
{
    public function __construct(
        private CreateUserOutputPort $output,
        private UserRepository $repository,
        private UserFactory $factory,
    ) {
    }

    public function createUser(CreateUserRequestModel $request): ViewModel
    {

        try {
            $user = $this->factory->makeUser([
                'email' => $request->getEmail(),
                'name' => $request->getName(),
    
            ]);
            
            if ($this->repository->exists($user)) {
                return $this->output->userAlreadyExists(new CreateUserResponseModel($user));
            }

            
            $user = $this->repository->create($user, new PasswordValueObject($request->getPassword()));
        } catch (\Exception $e) {
            return $this->output->unableToCreateUser(new CreateUserResponseModel($user), $e);
        }
        return $this->output->userCreated(
            new CreateUserResponseModel($user)
        );
    }
}