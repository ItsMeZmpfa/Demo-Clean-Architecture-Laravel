<?php

    namespace App\Domain\UseCases\CreateNewSchedule;

    use App\Domain\Interfaces\Schedule\ScheduleFactory;
    use App\Domain\Interfaces\Schedule\ScheduleRepository;
    use App\Domain\Interfaces\User\UserFactory;
    use App\Domain\Interfaces\User\UserRepository;
    use App\Domain\Interfaces\ViewModel;
    use App\Domain\Interfaces\WorkHour\WorkHourFactory;
    use App\Domain\Interfaces\WorkHour\WorkHourRepository;
    use Throwable;

    class CreateNewScheduleInteractor implements CreateNewScheduleInputPort
    {
        public function __construct(
            private CreateNewScheduleOutputPort $output,
            private ScheduleRepository $scheduleRepository,
            private ScheduleFactory $scheduleFactory,
            private WorkHourRepository $workHourRepository,
            private WorkHourFactory $workHourFactory,
            private UserRepository $userRepository,
            private UserFactory $userFactory,
        ) {
        }

        public function createSchedule(CreateNewScheduleRequestModel $request): ViewModel
        {

            try {
                $user = $this->userFactory->makeUser([
                    'userId' => $request->getEmployerId(),
                ]);


                $schedule = $this->scheduleFactory->makeSchedule([
                    'date' => $request->getScheduleDate(),
                    'user_id' => $request->getEmployerId(),
                ]);

                $workHour = $this->workHourFactory->makeWorkHour([
                    'startTime' => $request->getStartTime(),
                    'endTime' => $request->getEndTime(),
                ]);

                if (!$this->userRepository->existsbyId($user)) {
                    return $this->output->userNotExists(new CreateNewScheduleResponseModel($schedule, $workHour));
                }


                if ($this->scheduleRepository->exists($schedule)) {
                    return $this->output->scheduleAlreadyExists(new CreateNewScheduleResponseModel($schedule,
                        $workHour));
                }

                $schedule = $this->scheduleRepository->createSchedule($schedule);
                $workHour = $this->workHourRepository->createWorkHour($workHour, $schedule->getScheduleId());

            } catch (Throwable $e) {
                return $this->output->unableToCreateSchedule($e);
            }

            return $this->output->scheduleCreated(
                new CreateNewScheduleResponseModel($schedule, $workHour),
            );
        }

    }
