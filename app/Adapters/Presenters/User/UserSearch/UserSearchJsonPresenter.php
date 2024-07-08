<?php

    namespace App\Adapters\Presenters\User\UserSearch;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\UseCases\UserSearch\UserSearchOutputPort;
    use App\Domain\UseCases\UserSearch\UserSearchResponseModel;
    use App\Http\Resources\User\UnableToUserSearchResource;
    use App\Http\Resources\User\UserSearchResource;
    use Throwable;

    class UserSearchJsonPresenter implements UserSearchOutputPort
    {
        public function userSearch(UserSearchResponseModel $model): ViewModel
        {
            return new JsonResourceViewModel(
                new UserSearchResource($model->getUserRecord()),
            );
        }

        public function unableToUserSearch(UserSearchResponseModel $model, Throwable $e): ViewModel
        {
            if (config('app.debug')) {
                // rethrow and let Laravel display the error
                throw $e;
            }

            return new JsonResourceViewModel(
                new UnableToUserSearchResource($e),
            );
        }
    }
