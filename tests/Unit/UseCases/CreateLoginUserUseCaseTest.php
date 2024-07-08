<?php

    namespace Tests\Unit\UseCases;

    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\User\UserFactory;
    use App\Domain\Interfaces\User\UserRepository;
    use App\Domain\UseCases\LoginUser\LoginUserInteractor;
    use App\Domain\UseCases\LoginUser\LoginUserOutputPort;
    use App\Domain\UseCases\LoginUser\LoginUserRequestModel;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use Mockery;
    use Tests\ProvidesUsers;
    use Tests\TestCase;

    class CreateLoginUserUseCaseTest extends TestCase
    {
        use ProvidesUsers;

        /**
         *
         * @dataProvider userDataProvider
         */
        public function testInteractor(array $data)
        {

            (new LoginUserInteractor(
                $this->mockCreateUserPresenter($responseModel),
                $this->mockUserFactory($this->mockUserEntity($data)),
                $this->mockUserRepository(exists: false),
            ))->loginUser(
                $this->mockRequestModel($data),
            );
        }

        private function mockCreateUserPresenter(&$responseModel): LoginUserOutputPort
        {
            return tap(Mockery::mock(LoginUserOutputPort::class), function ($mock) use (&$responseModel) {
                $mock
                    ->shouldReceive('userLogin')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('unableToLoginUser')
                    ->with(Mockery::capture($responseModel));

                $mock
                    ->shouldReceive('unableToLogin')
                    ->with(Mockery::capture($responseModel), Mockery::capture($responseModel));
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
                    ->shouldReceive('getUserEmail')->andReturn(new EmailValueObject($data['email']))
                    ->shouldReceive('getUserPassword')->andReturn((new PasswordValueObject($data['password']))->hashed());
            });
        }

        private function mockUserRepository(bool $exists = false): UserRepository
        {
            return tap(Mockery::mock(UserRepository::class), function ($mock) use ($exists) {
                $mock
                    ->shouldReceive('findUserbyEmail')
                    ->with(UserEntity::class)
                    ->andReturnUsing(fn ($user) => $user);

                $mock
                    ->shouldReceive('create')
                    ->with(UserEntity::class, Mockery::type(PasswordValueObject::class))
                    ->andReturnUsing(fn ($user, $password) => $user);
            });
        }

        private function mockRequestModel(array $data): LoginUserRequestModel
        {
            return tap(Mockery::mock(LoginUserRequestModel::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getEmail')->once()->andReturn($data['email'])
                    ->shouldReceive('getPassword')->andReturn($data['password']);
            });
        }
    }
