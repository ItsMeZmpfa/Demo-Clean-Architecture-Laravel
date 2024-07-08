<?php

namespace App\Domain\UseCases\LoginUser;

use App\Domain\Interfaces\User\UserFactory;
use App\Domain\Interfaces\User\UserRepository;
use App\Domain\Interfaces\ViewModel;
use App\Models\PasswordValueObject;
use App\Domain\UseCases\LoginUser\LoginUserInputPort;
use Auth;

class LoginUserInteractor implements LoginUserInputPort
{
    private $token;
    public function __construct(
        private LoginUserOutputPort $output,
        private UserFactory $factory,
        private UserRepository $repository,
    ) {
    }

    public function loginUser(LoginUserRequestModel $request): ViewModel
    {
        $user = $this->factory->makeUser([
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ]);

        try {

            // Check The Email of the given User
            $userExists = $this->repository->exists($user);

            if(!$userExists){
                return $this->output->unableToLoginUser(new LoginUserResponseModel($user,$this->token));
            }
            $user = $this->repository->findUserbyEmail($user);

            //Check The Password of the given User
            if(!$user->getUserPassword()->check(new PasswordValueObject($request->getPassword())) && $userExists )
            {
                return $this->output->unableToLoginUser(new LoginUserResponseModel($user,$this->token));
            }

          //  $user->tokens()->delete();

            $this->token = $user->createToken('myapptoken')->plainTextToken;

        } catch (\Exception $e) {
            return $this->output->unableToLogin(new LoginUserResponseModel($user,$this->token), $e);
        }

        return $this->output->userLogin(
            new LoginUserResponseModel($user,$this->token)
        );
    }
}
