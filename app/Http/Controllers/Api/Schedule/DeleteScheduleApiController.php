<?php

    namespace App\Http\Controllers\Api\Schedule;

    use App\Adapters\ViewModels\JsonResourceViewModel;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleInputPort;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleRequestModel;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Schedule\CreateNewScheduleRequest;
    use Illuminate\Http\Resources\Json\JsonResource;

    class DeleteScheduleApiController extends Controller
    {
        public function __construct(private DeleteScheduleInputPort $interactor,)
        {

        }

        public function __invoke(CreateNewScheduleRequest $request): ?JsonResource
        {

            $viewModel = $this->interactor->deleteSchedule(
                new DeleteScheduleRequestModel($request->validated()),
            );

            if ($viewModel instanceof JsonResourceViewModel) {
                return $viewModel->getResource();
            }

            return null;
        }

    }
