<?php

    namespace FactoryAndDataBase;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\UseCases\LoginUser\LoginUserResponseModel;
    use App\Factories\User\UserModelFactory;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Repositories\User\UserDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class CreateLoginUserFactoryDatabaseTest extends TestCase
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

            $user = $repository->create($userMock, new PasswordValueObject($data['password']));

            $user = $repository->findUserbyEmail($userMock);

            $this->assertTrue($user->exists);
            $this->assertTrue($user->getUserPassword()->check(new PasswordValueObject($data['password'])));
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

        private function mockLoginUserResponseModel(UserEntity $user): LoginUserResponseModel
        {
            return tap(Mockery::mock(LoginUserResponseModel::class), function ($mock) use ($user) {
                $mock
                    ->shouldReceive('getUser')
                    ->andReturn($user);

                $mock
                    ->shouldReceive('getToken');
            });
        }
    }
