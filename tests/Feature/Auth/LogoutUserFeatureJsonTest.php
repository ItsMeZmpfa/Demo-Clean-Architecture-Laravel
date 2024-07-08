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

    class LogoutUserFeatureJsonTest extends TestCase
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

            $user = $repository->create($userMock, new PasswordValueObject($data['password']));

            //make an Api call with acting as a user for sanctum guard
            $response = $this->actingAs($user, 'sanctum')->postJson(route('send.loginNew', $data))->assertOk();
            //excepted Json response
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

    }
