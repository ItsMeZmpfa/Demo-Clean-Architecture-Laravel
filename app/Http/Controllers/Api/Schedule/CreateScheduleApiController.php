<?php

    namespace App\Http\Controllers\Api\Schedule;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleInputPort;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleRequestModel;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Schedule\CreateNewScheduleRequest;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CreateScheduleApiController extends Controller
    {
        public function __construct(private CreateNewScheduleInputPort $interactor,)
        {

        }

        public function __invoke(CreateNewScheduleRequest $request): ?JsonResource
        {
            $viewModel = $this->interactor->createSchedule(
                new CreateNewScheduleRequestModel($request->validated()),
            );

            if ($viewModel instanceof JsonResourceViewModel) {
                return $viewModel->getResource();
            }

            return null;
        }

    }
