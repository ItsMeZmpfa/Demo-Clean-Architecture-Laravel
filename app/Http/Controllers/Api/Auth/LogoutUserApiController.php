<?php

namespace App\Http\Controllers\Api\Auth;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\UseCases\LogoutUser\LogoutUserInputPort;
use App\Domain\UseCases\LogoutUser\LogoutUserRequestModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;


class LogoutUserApiController extends Controller
{
    public function __construct(private LogoutUserInputPort $interactor, )
    {

    }

    public function __invoke(Request $request): ?JsonResource
    {
        $viewModel = $this->interactor->LogoutUser(
            new LogoutUserRequestModel([])
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }

        return null;
    }
}
