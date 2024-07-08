<?php

    namespace FactoryAndDataBase;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\UseCases\CreateUser\CreateUserResponseModel;
    use App\Factories\User\UserModelFactory;
    use App\Http\Controllers\Api\CreateUserController;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesUsers;
    use Tests\TestCase;


    class CreateUserFactoryDatabaseTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesUsers;
        use ManipulatesConfig;

        /**
         * @dataProvider userDataProvider
         */
        public function testDatabaseRepository(array $data)
        {
            $userMock = $this->mockUser($data);
            $repository = new UserDatabaseRepository();

            $this->assertFalse($repository->exists($userMock));

            $user = $repository->create($userMock, new PasswordValueObject($data['password']));

            $this->assertTrue($user->exists);
            $this->assertTrue($repository->exists($userMock));
        }

        private function mockUser(array $data): UserEntity
        {
            return tap(Mockery::mock(UserEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserName')->andReturn($data['name'])
                    ->shouldReceive('getUserEmail')->andReturn(new EmailValueObject($data['email']))
                    ->shouldNotReceive('getUserPassword');
            });
        }

        /**
         * @dataProvider userDataProvider
         */
        public function testModelFactory(array $data)
        {
            $factory = new UserModelFactory();
            $user = $factory->makeUser($data);

            $this->assertUserMatches($data, $user);
        }

        private function mockCreateUserResponseModel(UserEntity $user): CreateUserResponseModel
        {
            return tap(Mockery::mock(CreateUserResponseModel::class), function ($mock) use ($user) {
                $mock
                    ->shouldReceive('getUser')
                    ->andReturn($user);
            });
        }

    }
