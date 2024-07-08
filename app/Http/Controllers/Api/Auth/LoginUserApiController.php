<?php

namespace App\Http\Controllers\Api\Auth;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\UseCases\LoginUser\LoginUserInputPort;
use App\Domain\UseCases\LoginUser\LoginUserRequestModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginUserApiController extends Controller
{
    public function __construct(private LoginUserInputPort $interactor, )
    {

    }

    public function __invoke(LoginUserRequest $request): ?JsonResource
    {
        $viewModel = $this->interactor->loginUser(
            new LoginUserRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }

        return null;
    }
}
