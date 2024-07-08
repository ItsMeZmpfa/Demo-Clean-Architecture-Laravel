<?php

    namespace Tests\Feature\Schedule;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Models\TimeValueObject;
    use App\Repositories\Schedule\ScheduleDatabaseRepository;
    use App\Repositories\User\UserDatabaseRepository;
    use App\Repositories\WorkHour\WorkHourDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesSchedules;
    use Tests\TestCase;

    class DeleteScheduleFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesSchedules;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider schedulewithUserDataProvider
         */
        public function deleteSchedule(array $data)
        {
            // Create a User with additional Schedule and Workhour for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();
            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            $data['dataSchedule']['user_id'] = $user->id;

            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            //Assigned the new Create User Id for Testing
            $data['dataDelete']['user_id'] = $user->id;

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('apidelete.schedule',
                $data['dataDelete']))->assertOk();
            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "Delete Schedule succussful.",
            ]);

        }

        private function mockUser(array $data): UserEntity
        {
            return tap(Mockery::mock(UserEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserName')->andReturn($data['name'])
                    ->shouldReceive('getUserEmail')->andReturn(new EmailValueObject($data['email']))
                    ->shouldReceive('getUserPassword')->andReturn((new PasswordValueObject($data['password']))->hashed());
            });
        }

        private function mockSchedule(array $data): ScheduleEntity
        {
            return tap(Mockery::mock(ScheduleEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserIdSchedule')->andReturn($data['user_id'])
                    ->shouldReceive('getScheduleDate')->andReturn(new TimeValueObject($data['date']));
            });
        }

        private function mockWorkHour(array $data): WorkHourEntity
        {
            return tap(Mockery::mock(WorkHourEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getWorkHourStartTime')->andReturn(new TimeValueObject($data['startTime']))
                    ->shouldReceive('getWorkHourEndTime')->andReturn(new TimeValueObject($data['endTime']));
            });
        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProvider
         */
        public function jsonUserNotExists(array $data)
        {
            // Create a User with additional Schedule and Workhour for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);
            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            //Assigned the new Create User Id for Testing
            $data['dataSchedule']['user_id'] = $user->id;

            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            //Change User Id to a Non-Exists
            $data['dataDelete']['user_id'] = 500;

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('apidelete.schedule',
                $data['dataDelete']))->assertStatus(402);

            $response->assertJsonFragment([
                'message' => "Schedule isnt Exists.",
            ]);

        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProvider
         */

        public function jsonDateNotExists(array $data)
        {
            // Create a User with additional Schedule and Workhour for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $repository = new UserDatabaseRepository();
            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            //Assigned the new Create User Id for Testing
            $data['dataSchedule']['user_id'] = $user->id;

            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            //Change User Id to a Non-Exists
            $data['dataDelete']['date'] = "2011-12-12 00:00:00";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('apidelete.schedule',
                $data['dataDelete']))->assertStatus(402);

            $response->assertJsonFragment([
                'message' => "Schedule isnt Exists.",
            ]);

        }

        /**
         * @test
         * @dataProvider schedulewithScheduleEmptyTestData
         */
        public function jsonScheduleWrongDateFormat(array $data)
        {
            // Create a User with additional Schedule and Workhour for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();
            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            $data['dataSchedule']['user_id'] = $user->id;
            $data['dataDelete']['user_id'] = $user->id;
            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            //Change User Id to a Non-Exists
            $data['dataDelete']['date'] = "89289478923 8234";
            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('apidelete.schedule',
                $data['dataDelete']));

            $response->assertJsonFragment([
                'error' => "The given Date is not valid",
                'help' => "Check if the given Date is valid",
            ]);
        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProvider
         */
        public function jsonEmptyDateFormat(array $data)
        {
            // Create a User with additional Schedule and Workhour for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();
            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            
            //Assigned the new Create User Id for Testing
            $data['dataSchedule']['user_id'] = $user->id;

            $scheduleMock = $this->mockSchedule($data['dataSchedule']);
            $workHourMock = $this->mockWorkHour($data['dataWorkHour']);

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            //Change User Id to a Non-Exists
            $data['dataDelete']['date'] = "";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('apidelete.schedule',
                $data['dataDelete']))->assertStatus(400);


            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                'help' => "Check if the given input is valid",
            ]);
        }

    }
