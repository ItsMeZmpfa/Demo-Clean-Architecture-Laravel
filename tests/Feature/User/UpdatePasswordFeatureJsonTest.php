<?php

    namespace Tests\Feature\User;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesSchedules;
    use Tests\TestCase;

    class UpdatePasswordFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesSchedules;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider schedulewithUserDataProvider
         */
        public function updateUserPassword(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.user',
                ["password" => "12341234Test"]))->assertOk();
            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "Update Succusfully",
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
         * @dataProvider schedulewithUserDataProvider
         */
        public function updateEmptyPassword(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('update.user',
                ["password" => ""]))->assertStatus(400);
            //excepted Json Response
            $response->assertJsonFragment([
                "error" => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ]);

        }
    }
