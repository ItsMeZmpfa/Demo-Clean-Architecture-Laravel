<?php

    namespace Tests\Unit\UseCases;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\User\UserFactory;
    use App\Domain\Interfaces\User\UserRepository;
    use App\Domain\UseCases\CreateUser\CreateUserInteractor;
    use App\Domain\UseCases\CreateUser\CreateUserOutputPort;
    use App\Domain\UseCases\CreateUser\CreateUserRequestModel;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use Mockery;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class CreateUserUseCaseTest extends TestCase
    {
        use ProvidesUsers;

        /**
         *
         * @dataProvider userDataProvider
         */
        public function testInteractor(array $data)
        {

            (new CreateUserInteractor(
                $this->mockCreateUserPresenter($responseModel),
                $this->mockUserRepository(exists: false),
                $this->mockUserFactory($this->mockUserEntity($data)),
            ))->createUser(
                $this->mockRequestModel($data),
            );
            $this->assertUserMatches($data, $responseModel->getUser());
        }

        private function mockCreateUserPresenter(&$responseModel): CreateUserOutputPort
        {
            return tap(Mockery::mock(CreateUserOutputPort::class), function ($mock) use (&$responseModel) {
                $mock
                    ->shouldReceive('userCreated')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('unableToCreateUser')
                    ->with(Mockery::capture($responseModel), Mockery::capture($responseModel));
            });
        }

        private function mockUserRepository(bool $exists = false): UserRepository
        {
            return tap(Mockery::mock(UserRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('exists')
                    ->with(UserEntity::class)
                    ->andReturn($exists);

                $mock
                    ->shouldReceive('create')
                    ->with(UserEntity::class, Mockery::type(PasswordValueObject::class))
                    ->andReturnUsing(fn ($user, $password) => $user);
            });
        }

        private function mockUserFactory(UserEntity $user): UserFactory
        {
            return tap(Mockery::mock(UserFactory::class), function ($mock) use ($user) {
                $mock
                    ->shouldReceive('makeUser')
                    ->with(Mockery::type('array'))
                    ->andReturn($user);
            });
        }

        private function mockUserEntity(array $data): UserEntity
        {
            return tap(Mockery::mock(UserEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserName')->andReturn($data['name'])
                    ->shouldReceive('getUserEmail')->andReturn(new EmailValueObject($data['email']))
                    ->shouldReceive('getUserPassword')->andReturn((new PasswordValueObject($data['password']))->hashed());
            });
        }

        private function mockRequestModel(array $data): CreateUserRequestModel
        {
            return tap(Mockery::mock(CreateUserRequestModel::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getName')->once()->andReturn($data['name'])
                    ->shouldReceive('getEmail')->once()->andReturn($data['email'])
                    ->shouldReceive('getPassword')->andReturn($data['password']);
            });
        }
    }
