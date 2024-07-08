<?php

    namespace Tests\Feature\WorkHour;

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

    class UpdateWorkHourFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesSchedules;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider schedulewithUserDataProviderUpdate
         */
        public function updateWorkHour(array $data)
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
            //Assigned the new Create Schedule Id for Testing
            $data['dataUpdate']['scheduleId'] = $schedule->id;

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(200);

            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "WorkHour is update.",
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
         * @dataProvider schedulewithUserDataProviderUpdate
         */
        public function updateWorkHourWithWrongDate(array $data)
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
            //Assigned the new Create Schedule Id for Testing
            $data['dataUpdate']['scheduleId'] = $schedule->id;
            $data['dataUpdate']['startTime'] = "24234 234234 23";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(400);

            //excepted Json Response
            $response->assertJsonFragment([
                "error" => "The given Date is not valid",
                "help" => "Check if the given Date is valid",
            ],
            );
            //change Date to a wrong invalid Format
            $data['dataUpdate']['endTime'] = "24234 234234 23";

            // Create a User with additional Schedule and Workhour for Testing
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']));
            //excepted Json Response
            $response->assertJsonFragment([
                "error" => "The given Date is not valid",
                "help" => "Check if the given Date is valid",
            ],
            );

        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProviderUpdate
         */
        public function updateWorkHourWithEmptyDate(array $data)
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
            //Assigned the new Create Schedule Id for Testing
            $data['dataUpdate']['scheduleId'] = $schedule->id;
            $data['dataUpdate']['startTime'] = "";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(400);

            //excepted Json Response
            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ],
            );

            $data['dataUpdate']['endTime'] = "";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(400);
            //excepted Json Response
            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ],
            );

        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProviderUpdate
         */
        public function updateWorkHourWithWrongSchedule(array $data)
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
            //Change Schedule Id to not exists
            $data['dataUpdate']['scheduleId'] = 100;

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(402);

            //excepted Json Response
            $response->assertJsonFragment([
                "message" => "WorkHour isn't exists.",
            ],
            );

        }

        /**
         * @test
         * @dataProvider schedulewithUserDataProviderUpdate
         */
        public function updateWorkHourWithWrongScheduleEmpty(array $data)
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
            //Change Schedule Id to non Exists
            $data['dataUpdate']['scheduleId'] = "";

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.workhour',
                $data['dataUpdate']))->assertStatus(400);

            //excepting Json Response
            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ],
            );

        }

    }
