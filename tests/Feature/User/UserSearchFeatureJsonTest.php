<?php

    namespace Tests\Feature\User;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class UserSearchFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesUsers;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserNoCredentials(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as user
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData'))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
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
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithName(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['name' => "Test User1"]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithId(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an user
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['userId' => $user3->id]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithEmail(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as a User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['email' => $user2->email]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithNotMatchId(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an user
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['userId' => 20]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithNotMatchName(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an user
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['name' => "Bla Bla"]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }

        /**
         * @test
         * @dataProvider userSearchDataProvider
         */
        public function searchUserWithNotMatchEmail(array $data)
        {
            // Create a User1 for Testing
            $userMock = $this->mockUser($data['user1']);
            $userMock2 = $this->mockUser($data['user2']);
            $userMock3 = $this->mockUser($data['user3']);

            $repository = new UserDatabaseRepository();

            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));
            $user2 = $repository->create($userMock2, new PasswordValueObject("Test12341234"));
            $user3 = $repository->create($userMock3, new PasswordValueObject("Test12341234"));

            // Create Api Call acting as an User
            $response = $this->actingAs($user, 'sanctum')->postJson(route('api.get.userData',
                ['email' => "Bla@test.de"]))->assertOk();
            //excepted Json Response
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
        }
    }
