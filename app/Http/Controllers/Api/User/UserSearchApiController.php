<?php

    namespace App\Http\Controllers\Api\User;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\UseCases\UserSearch\UserSearchInputPort;
    use App\Domain\UseCases\UserSearch\UserSearchRequestModel;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\UserSearchRequest;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserSearchApiController extends Controller
    {
        public function __construct(
            private UserSearchInputPort $interactor,
        ) {
        }

        public function __invoke(UserSearchRequest $request): ?JsonResource
        {
            $viewModel = $this->interactor->searchUser(
                new UserSearchRequestModel($request->validated()),
            );

            if ($viewModel instanceof JsonResourceViewModel) {

                return $viewModel->getResource();
            }

            return null;
        }
    }
