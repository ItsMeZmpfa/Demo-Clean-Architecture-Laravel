<?php

    namespace App\Adapters\Presenters\User\LogoutUser;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\UseCases\LogoutUser\LogoutUserOutputPort;
    use App\Domain\UseCases\LogoutUser\LogoutUserResponseModel;
    use App\Http\Resources\User\UnableToLogoutResource;
    use App\Http\Resources\User\UserLogoutResource;
    use Throwable;

    class LogoutUserJsonPresenter implements LogoutUserOutputPort
    {
        public function userLogout(LogoutUserResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserLogoutResource(),
            );
        }

        public function unableToLogoutUser(LogoutUserResponseModel $model, Throwable $e): ViewModel
        {
            return new JsonResourceViewModel(
                new UnableToLogoutResource(),
            );
        }

    }
