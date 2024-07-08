<?php

    namespace App\Domain\UseCases\DeleteSchedule;

    use App\Domain\Interfaces\Schedule\ScheduleFactory;
    use App\Domain\Interfaces\Schedule\ScheduleRepository;
    use App\Domain\Interfaces\ViewModel;
    use Exception;

    class DeleteScheduleInteractor implements DeleteScheduleInputPort
    {
        public function __construct(
            private DeleteScheduleOutputPort $output,
            private ScheduleRepository $scheduleRepository,
            private ScheduleFactory $scheduleFactory,
        ) {
        }

        public function deleteSchedule(DeleteScheduleRequestModel $request): ViewModel
        {
            try {

                $schedule = $this->scheduleFactory->makeSchedule([
                    'date' => $request->getScheduleDate(),
                    'user_id' => $request->getEmployerId(),
                ]);

                if (!$this->scheduleRepository->exists($schedule)) {
                    return $this->output->scheduleNotExists(new DeleteScheduleResponseModel(false));
                }

                $schedule = $this->scheduleRepository->deleteSchedule($schedule);

            } catch (Exception $e) {
                return $this->output->unableToDeleteSchedule($e);
            }

            return $this->output->scheduleDelete(
                new DeleteScheduleResponseModel(true),
            );
        }

    }
