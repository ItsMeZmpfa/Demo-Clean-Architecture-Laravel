<?php

    namespace App\Adapters\Presenters\User\CreateUser;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\UseCases\CreateUser\CreateUserOutputPort;
    use App\Domain\UseCases\CreateUser\CreateUserResponseModel;
    use App\Http\Resources\User\UnableToCreateUserResource;
    use App\Http\Resources\User\UserAlreadyExistsResource;
    use App\Http\Resources\User\UserCreatedResource;
    use Throwable;

    class CreateUserJsonPresenter implements CreateUserOutputPort
    {
        public function userCreated(CreateUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserCreatedResource(),
            );
        }

        public function userAlreadyExists(CreateUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserAlreadyExistsResource(),
            );
        }

        public function unableToCreateUser(CreateUserResponseModel $model, Throwable $e): ViewModel
        {
            if (config('app.debug')) {
                // rethrow and let Laravel display the error
                throw $e;
            }

            return new JsonResourceViewModel(
                new UnableToCreateUserResource($e),
            );
        }
    }
