<?php

    namespace App\Adapters\Presenters\User\UpdateUser;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\UseCases\UpdateUser\UpdateUserOutputPort;
    use App\Domain\UseCases\UpdateUser\UpdateUserResponseModel;
    use App\Http\Resources\User\UnableToUpdateUserResource;
    use App\Http\Resources\User\UserUpdateResource;
    use Throwable;

    class UpdateUserJsonPresenter implements UpdateUserOutputPort
    {
        public function userUpdate(UpdateUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserUpdateResource(),
            );
        }

        public function unableToUpdateUser(UpdateUserResponseModel $model, Throwable $e): ViewModel
        {
            if (config('app.debug')) {
                // rethrow and let Laravel display the error
                throw $e;
            }

            return new JsonResourceViewModel(
                new UnableToUpdateUserResource(),
            );
        }
    }
