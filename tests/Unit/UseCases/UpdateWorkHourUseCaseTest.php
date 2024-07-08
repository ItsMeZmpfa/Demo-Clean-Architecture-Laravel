<?php

    namespace Tests\Unit\UseCases;

    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourFactory;
    use App\Domain\Interfaces\WorkHour\WorkHourRepository;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourInteractor;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourOutputPort;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourRequestModel;
    use App\Models\TimeValueObject;
    use Mockery;
    use Tests\ProvidesWorkHour;
    use Tests\TestCase;

    class UpdateWorkHourUseCaseTest extends TestCase
    {
        use ProvidesWorkHour;

        /**
         * @test
         * @dataProvider workHourDataProvider
         */
        public function testInteractor(array $data)
        {

            (new UpdateWorkHourInteractor(
                $this->mockWorkHourPresenter($responseModel),
                $this->mockWorkHourRepository(exists: false),
                $this->mockWorkHourFactory($this->mockWorkHourEntity($data)),
            ))->updateWorkHour(
                $this->mockRequestModel($data),
            );

            $this->checkWorkHourIsNotUpdate($responseModel->getUpdateWorkHour());
        }

        private function mockWorkHourPresenter(&$responseModel): UpdateWorkHourOutputPort
        {
            return tap(Mockery::mock(UpdateWorkHourOutputPort::class), function ($mock) use (&$responseModel) {
                $mock
                    ->shouldReceive('workHourUpdate')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('workHourNotExists')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('unableToUpdateWorkHour')
                    ->with(Mockery::capture($responseModel), Mockery::capture($responseModel));
            });
        }

        private function mockWorkHourRepository(bool $exists = false): WorkHourRepository
        {
            return tap(Mockery::mock(WorkHourRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('existsSchedule')
                    ->with(WorkHourEntity::class)
                    ->andReturn($exists);

                $mock
                    ->shouldReceive('updateWorkHour')
                    ->with(WorkHourEntity::class)
                    ->andReturnUsing(fn ($workHour) => $workHour);
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
                    ->shouldReceive('getWorkHourScheduleId')->andReturn(1)
                    ->shouldReceive('getWorkHourStartTime')->andReturn(new TimeValueObject("2005-01-01 04:00:00"))
                    ->shouldReceive('getWorkHourEndTime')->andReturn(new TimeValueObject("2005-01-01 16:00:00"));
            });
        }

        private function mockRequestModel(array $data): UpdateWorkHourRequestModel
        {
            return tap(Mockery::mock(UpdateWorkHourRequestModel::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getStartTime')->once()->andReturn("2005-01-01 04:00:00")
                    ->shouldReceive('getEndTime')->once()->andReturn("2005-01-01 16:00:00")
                    ->shouldReceive('getScheduleId')->andReturn(1);
            });
        }
    }
