<?php

    namespace App\Http\Controllers\Api\WorkHour;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourInputPort;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourRequestModel;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\WorkHour\UpdateWorkHourRequest;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UpdateWorkHourApiController extends Controller
    {
        public function __construct(private UpdateWorkHourInputPort $interactor,)
        {

        }

        public function __invoke(UpdateWorkHourRequest $request): ?JsonResource
        {

            $viewModel = $this->interactor->updateWorkHour(
                new UpdateWorkHourRequestModel($request->validated()),
            );


            if ($viewModel instanceof JsonResourceViewModel) {
                return $viewModel->getResource();
            }

            return null;
        }

    }
