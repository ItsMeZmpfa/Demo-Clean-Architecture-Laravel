<?php

    namespace App\Adapters\Presenters\User\LoginUser;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\UseCases\LoginUser\LoginUserOutputPort;
    use App\Domain\UseCases\LoginUser\LoginUserResponseModel;
    use App\Http\Resources\User\UnableToLoginResource;
    use App\Http\Resources\User\UnableToLoginUserResource;
    use App\Http\Resources\User\UserLoginResource;
    use Throwable;

    class LoginUserJsonPresenter implements LoginUserOutputPort
    {
        public function userLogin(LoginUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserLoginResource($model->getToken()),
            );
        }

        public function unableToLoginUser(LoginUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UnableToLoginResource(),
            );
        }

        public function unableToLogin(LoginUserResponseModel $model, Throwable $e): ViewModel
        {
            if (config('app.debug')) {
                // rethrow and let Laravel display the error
                throw $e;
            }

            return new JsonResourceViewModel(
                new UnableToLoginUserResource($e),
            );
        }
    }
