<?php

    namespace Tests\Feature\Schedule;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesSchedules;
    use Tests\TestCase;

    class CreateNewScheduleFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesSchedules;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */

        public function jsonCreateNewSchedule(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            $data['user_id'] = $user->id;

            // Create Api Call
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertOk();

            $response->assertJsonFragment([
                'message' => "Schedule created.",
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

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */

        public function jsonScheduleAlreadyExists(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            //Swap the id that with the new created User
            $data["user_id"] = $user->id;
            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertOk();
            //expect to be Created
            $response->assertJsonFragment([
                'message' => "Schedule created.",
            ]);
            //Same call with same Data
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(401);
            //expected Error with Already exists
            $response->assertJsonFragment([
                'message' => "Schedule Already Exists.",
            ]);
        }

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */
        public function jsonScheduleWrongDateFormat(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            //Change Start Time Date to a Wrong Format
            $data['startTime'] = "14231234254";
            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);
            $response->assertJsonFragment([
                "error" => "The given Date is not valid",
                "help" => "Check if the given Date is valid",
            ]);

            //Change End Time Date to a Wrong Format
            $data['endTime'] = "14:231 2342 54";

            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);

            $response->assertJsonFragment([
                "error" => "The given Date is not valid",
                "help" => "Check if the given Date is valid",
            ]);

            //Change Date to a Wrong Format
            $data['date'] = "14:231 2342 54";

            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);

            $response->assertJsonFragment([
                "error" => "The given Date is not valid",
                "help" => "Check if the given Date is valid",
            ]);
        }

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */
        public function jsonScheduleUserNotExists(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            //Change User Id to a Random
            $data['user_id'] = 555;

            // Create Call
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(402);

        }

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */
        public function jsonEmptyDateFormat(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            //Change Start Time Date to a Wrong Format
            $data['startTime'] = "";
            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);

            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
            ]);

            //Change End Time Date to a Wrong Format
            $data['endTime'] = "";

            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);

            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
            ]);

            //Change Date to a Wrong Format
            $data['date'] = "";

            // Create First Call with Schedule
            $response = $this->actingAs($user, 'sanctum')->postJson(route('create.schedule', $data))->assertStatus(400);

            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                'help' => "Check if the given input is valid",
            ]);


        }

    }
