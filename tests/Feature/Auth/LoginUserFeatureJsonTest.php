<?php

    namespace Tests\Feature\Auth;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class LoginUserFeatureJsonTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesUsers;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider userDataProvider
         */
        public function jsonLoginSuccessTest(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $repository->create($userMock, new PasswordValueObject($data['password']));

            //Make Api Request Call
            $response = $this->postJson(route('send.loginNew', $data))->assertOk();

            //Expect json Response with Json Structure
            $response->assertJsonStructure([
                'data' => [
                    'token',
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
         * @dataProvider userDataProvider
         */
        public function jsonWrongPasswordSendTest(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $repository->create($userMock, new PasswordValueObject($data['password']));
            //change password to a wrong one
            $data['password'] = "dfgdfgdfsdf";

            //make Api request
            $response = $this->postJson(route('send.loginNew', $data))->assertStatus(403);

            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "Login unsuccussfully.",
            ]);
        }

        /**
         * @test
         * @dataProvider userDataProvider
         */
        public function jsonWrongEmailSendTest(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $repository->create($userMock, new PasswordValueObject($data['password']));
            //change Email to not exists email
            $data['email'] = "pla@test.de";

            //make an Api call
            $response = $this->postJson(route('send.loginNew', $data));

            //excepted Json Response
            $response->assertJsonFragment([
                'message' => "Login unsuccussfully.",
            ]);
        }

        /**
         * @test
         * @dataProvider userDataProvider
         */

        public function jsonEmptyEmailSendTest(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $repository->create($userMock, new PasswordValueObject($data['password']));
            //Change Email to a non exists email
            $data['email'] = "";
            //Make Api Call
            $response = $this->postJson(route('send.loginNew', $data));
            //Excepted Json Response
            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ]);
        }

        /**
         * @test
         * @dataProvider userDataProvider
         */

        public function jsonEmptyPasswordSendTest(array $data)
        {
            // Create a User for Testing
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $repository->create($userMock, new PasswordValueObject($data['password']));
            //Change password to an empty password
            $data['password'] = "";
            //Make APi Call
            $response = $this->postJson(route('send.loginNew', $data));
            //excepted Json Response
            $response->assertJsonFragment([
                'error' => "Something went wrong with Input Your provide",
                "help" => "Check if the given input is valid",
            ]);
        }

    }
