<?php

    namespace Tests\Unit\UseCases;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\Schedule\ScheduleFactory;
    use App\Domain\Interfaces\Schedule\ScheduleRepository;
    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\User\UserFactory;
    use App\Domain\Interfaces\User\UserRepository;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourFactory;
    use App\Domain\Interfaces\WorkHour\WorkHourRepository;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleInteractor;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleOutputPort;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleRequestModel;
    use App\Models\PasswordValueObject;
    use App\Models\TimeValueObject;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ProvidesSchedules;
    use Tests\TestCase;

    class CreateNewScheduleUseCaseTest extends TestCase
    {
        use ProvidesSchedules;
        use RefreshDatabase;

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */
        public function testInteractor(array $data)
        {

            (new CreateNewScheduleInteractor(
                $this->mockNewSchedulePresenter($responseModel),
                $this->mockScheduleRepository(exists: false),
                $this->mockScheduleFactory($this->mockScheduleEntity($data)),
                $this->mockWorkHourRepository(exists: false),
                $this->mockWorkHourFactory($this->mockWorkHourEntity($data)),
                $this->mockUserRepository(exists: false),
                $this->mockUserFactory($this->mockUserEntity($data)),
            ))->createSchedule(
                $this->mockRequestModel($data),
            );
            $this->assertScheduleMatches($data, $responseModel->getSchedule());
            $this->assertWorkHourMatches($data, $responseModel->getWorkHour());
        }

        private function mockNewSchedulePresenter(&$responseModel): CreateNewScheduleOutputPort
        {
            return tap(Mockery::mock(CreateNewScheduleOutputPort::class), function ($mock) use (&$responseModel) {
                $mock
                    ->shouldReceive('scheduleCreated')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('scheduleAlreadyExists')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('workHourAlreadyExists')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('userNotExists')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('unableToCreateSchedule')
                    ->with(Mockery::capture($responseModel), Mockery::capture($responseModel));
            });
        }

        private function mockScheduleRepository(bool $exists = false): ScheduleRepository
        {
            return tap(Mockery::mock(ScheduleRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('exists')
                    ->with(ScheduleEntity::class)
                    ->andReturn($exists);

                $mock
                    ->shouldReceive('createSchedule')
                    ->with(ScheduleEntity::class)
                    ->andReturnUsing(fn ($schedule) => $schedule);
            });
        }

        private function mockScheduleFactory(ScheduleEntity $schedule): ScheduleFactory
        {
            return tap(Mockery::mock(ScheduleFactory::class), function ($mock) use ($schedule) {
                $mock
                    ->shouldReceive('makeSchedule')
                    ->with(Mockery::type('array'))
                    ->andReturn($schedule);
            });
        }

        private function mockScheduleEntity(array $data): ScheduleEntity
        {
            return tap(Mockery::mock(ScheduleEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getScheduleDate')->andReturn(new TimeValueObject($data['date']))
                    ->shouldReceive('getUserIdSchedule')->andReturn($data['user_id'])
                    ->shouldReceive('getScheduleId');
            });
        }

        private function mockWorkhourRepository(bool $exists = false): WorkHourRepository
        {
            return tap(Mockery::mock(WorkHourRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('exists')
                    ->with(WorkHourEntity::class)
                    ->andReturn($exists);

                $mock
                    ->shouldReceive('createWorkHour')
                    ->with(WorkHourEntity::class, Mockery::type('integer'))
                    ->andReturnUsing(fn ($workHour, $id) => $workHour);
            });
        }

        private function mockWorkHourFactory(WorkHourEntity $workHour): WorkHourFactory
        {
            return tap(Mockery::mock(WorkHourFactory::class), function ($mock) use ($workHour) {
                $mock
                    ->shouldReceive('makeWorkHour')
                    ->with(Mockery::type('array'))
                    ->andReturn($workHour);
            });
        }

        private function mockWorkHourEntity(array $data): WorkHourEntity
        {
            return tap(Mockery::mock(WorkHourEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getWorkHourStartTime')->andReturn(new TimeValueObject($data['startTime']))
                    ->shouldReceive('getWorkHourEndTime')->andReturn(new TimeValueObject($data['endTime']));
            });
        }

        private function mockUserRepository(bool $exists = false): UserRepository
        {
            return tap(Mockery::mock(UserRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('existsbyId')
                    ->with(UserEntity::class)
                    ->andReturn($exists);

                $mock
                    ->shouldReceive('create')
                    ->with(UserEntity::class, Mockery::type(PasswordValueObject::class))
                    ->andReturnUsing(fn ($user, $password) => $user);
            });
        }

        private function mockUserFactory(UserEntity $user): UserFactory
        {
            return tap(Mockery::mock(UserFactory::class), function ($mock) use ($user) {
                $mock
                    ->shouldReceive('makeUser')
                    ->with(Mockery::type('array'))
                    ->andReturn($user);
            });
        }

        private function mockUserEntity(array $data): UserEntity
        {
            return tap(Mockery::mock(UserEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getEmployerId')->andReturn($data['user_id']);
            });
        }

        private function mockRequestModel(array $data): CreateNewScheduleRequestModel
        {
            return tap(Mockery::mock(CreateNewScheduleRequestModel::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getEmployerId')->andReturn($data['user_id'])
                    ->shouldReceive('getScheduleDate')->andReturn($data['date'])
                    ->shouldReceive('getStartTime')->andReturn($data['startTime'])
                    ->shouldReceive('getEndTime')->andReturn($data['endTime']);
            });
        }
    }
