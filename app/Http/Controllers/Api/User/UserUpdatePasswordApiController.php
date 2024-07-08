<?php

    namespace App\Http\Controllers\Api\User;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\UseCases\UpdateUser\UpdateUserInputPort;
    use App\Domain\UseCases\UpdateUser\UpdateUserRequestModel;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\User\UpdateUserPasswordRequest;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserUpdatePasswordApiController extends Controller
    {
        public function __construct(
            private UpdateUserInputPort $interactor,
        ) {
        }

        public function __invoke(UpdateUserPasswordRequest $request): ?JsonResource
        {
            $viewModel = $this->interactor->updateUser(
                new UpdateUserRequestModel($request->validated()),
            );

            if ($viewModel instanceof JsonResourceViewModel) {

                return $viewModel->getResource();
            }

            return null;
        }
    }
