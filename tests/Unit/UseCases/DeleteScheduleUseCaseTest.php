<?php

    namespace Tests\Unit\UseCases;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\Schedule\ScheduleFactory;
    use App\Domain\Interfaces\Schedule\ScheduleRepository;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleInteractor;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleOutputPort;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleRequestModel;
    use App\Models\TimeValueObject;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ProvidesDeleteSchedules;
    use Tests\TestCase;

    class DeleteScheduleUseCaseTest extends TestCase
    {
        use ProvidesDeleteSchedules;
        use RefreshDatabase;

        /**
         * @test
         * @dataProvider scheduleDeleteDataProvider
         */
        public function testInteractorEmptySchedule(array $data)
        {

            (new DeleteScheduleInteractor(
                $this->mockDeleteSchedulePresenter($responseModel),
                $this->mockScheduleRepository(exists: false),
                $this->mockScheduleFactory($this->mockScheduleEntity($data)),
            ))->deleteSchedule(
                $this->mockRequestModel($data),
            );

            $this->assertScheduleEmpty($data, $responseModel->getStatusOfDelete());

        }

        private function mockDeleteSchedulePresenter(&$responseModel): DeleteScheduleOutputPort
        {
            return tap(Mockery::mock(DeleteScheduleOutputPort::class), function ($mock) use (&$responseModel) {
                $mock
                    ->shouldReceive('scheduleDelete')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('scheduleNotExists')
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
                    ->shouldReceive('deleteSchedule')
                    ->with(ScheduleEntity::class)
                    ->andReturnUsing(fn ($schedule) => true);
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
                    ->shouldReceive('getUserIdSchedule')->andReturn($data['user_id']);
            });
        }

        private function mockRequestModel(array $data): DeleteScheduleRequestModel
        {
            return tap(Mockery::mock(DeleteScheduleRequestModel::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getEmployerId')->andReturn($data['user_id'])
                    ->shouldReceive('getScheduleDate')->andReturn($data['date']);
            });
        }

        /**
         * @test
         * @dataProvider scheduleDeleteDataProvider
         */
        public function testInteractorNotEmptySchedule(array $data)
        {


            (new DeleteScheduleInteractor(
                $this->mockDeleteSchedulePresenter($responseModel),
                $this->mockScheduleRepository(exists: true),
                $this->mockScheduleFactory($this->mockScheduleEntity($data)),
            ))->deleteSchedule(
                $this->mockRequestModel($data),
            );

            $this->assertScheduleNotEmpty($data, $responseModel->getStatusOfDelete());

        }
    }
