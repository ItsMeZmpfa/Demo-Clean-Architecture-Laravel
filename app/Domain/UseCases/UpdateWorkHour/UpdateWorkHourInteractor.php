<?php

    namespace App\Domain\UseCases\UpdateWorkHour;

    use App\Domain\Interfaces\ViewModel;
    use App\Domain\Interfaces\WorkHour\WorkHourFactory;
    use App\Domain\Interfaces\WorkHour\WorkHourRepository;
    use Exception;

    class UpdateWorkHourInteractor implements UpdateWorkHourInputPort
    {
        public function __construct(
            private UpdateWorkHourOutputPort $output,
            private WorkHourRepository $workHourRepository,
            private WorkHourFactory $workHourFactory,
        ) {
        }

        public function updateWorkHour(UpdateWorkHourRequestModel $request): ViewModel
        {

            $workHour = $this->workHourFactory->makeWorkHour([
                'startTime' => $request->getStartTime(),
                'endTime' => $request->getEndTime(),
                'scheduleId' => $request->getScheduleId(),

            ]);

            try {
                if (!$this->workHourRepository->existsSchedule($workHour)) {
                    return $this->output->workHourNotExists(new UpdateWorkHourResponseModel(false));
                }
                $workHour = $this->workHourRepository->UpdateWorkHour($workHour);

            } catch (Exception $e) {
                return $this->output->unableToUpdateWorkHour(new UpdateWorkHourResponseModel(false), $e);
            }

            return $this->output->workHourUpdate(
                new UpdateWorkHourResponseModel($workHour),
            );
        }

    }
