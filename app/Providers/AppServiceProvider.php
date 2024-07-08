<?php

    namespace App\Providers;

    use App\Adapters\Presenters;
    use App\Domain;
    use App\Domain\UseCases;
    use App\Factories;
    use App\Http\Controllers as ApiControllers;
    use App\Repositories;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         */
        public function register(): void
        {
            $this->app->bind(
                Domain\Interfaces\User\UserFactory::class,
                Factories\User\UserModelFactory::class,
            );

            $this->app->bind(
                Domain\Interfaces\User\UserRepository::class,
                Repositories\User\UserDatabaseRepository::class,
            );

            $this->app->bind(
                Domain\Interfaces\Schedule\ScheduleFactory::class,
                Factories\Schedule\ScheduleModelFactory::class,
            );

            $this->app->bind(
                Domain\Interfaces\Schedule\ScheduleRepository::class,
                Repositories\Schedule\ScheduleDatabaseRepository::class,
            );

            $this->app->bind(
                Domain\Interfaces\WorkHour\WorkHourFactory::class,
                Factories\WorkHour\WorkHourModelFactory::class,
            );

            $this->app->bind(
                Domain\Interfaces\WorkHour\WorkHourRepository::class,
                Repositories\WorkHour\WorkHourDatabaseRepository::class,
            );

            /** User Search Controller */

            $this->app
                ->when(ApiControllers\Api\User\UserSearchApiController::class)
                ->needs(UseCases\UserSearch\UserSearchInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\UserSearch\UserSearchInteractor::class, [
                        'output' => $app->make(Presenters\User\UserSearch\UserSearchJsonPresenter::class),
                    ]);
                });

            /** Create User Schedule */
            $this->app
                ->when(ApiControllers\Api\User\RegisterUserApiController::class)
                ->needs(UseCases\CreateUser\CreateUserInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\CreateUser\CreateUserInteractor::class, [
                        'output' => $app->make(Presenters\User\CreateUser\CreateUserJsonPresenter::class),
                    ]);
                });


            /** Login User Controller */

            $this->app
                ->when(ApiControllers\Api\Auth\LoginUserApiController::class)
                ->needs(UseCases\LoginUser\LoginUserInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\LoginUser\LoginUserInteractor::class, [
                        'output' => $app->make(Presenters\User\LoginUser\LoginUserJsonPresenter::class),
                    ]);
                });

            /** Logout User Controller */
            $this->app
                ->when(ApiControllers\Api\Auth\LogoutUserApiController::class)
                ->needs(UseCases\LogoutUser\LogoutUserInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\LogoutUser\LogoutUserInteractor::class, [
                        'output' => $app->make(Presenters\User\LogoutUser\LogoutUserJsonPresenter::class),
                    ]);
                });

            /**Create Schedule Controller */

            $this->app
                ->when(ApiControllers\Api\Schedule\CreateScheduleApiController::class)
                ->needs(UseCases\CreateNewSchedule\CreateNewScheduleInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\CreateNewSchedule\CreateNewScheduleInteractor::class, [
                        'output' => $app->make(Presenters\Schedule\CreateSchedule\CreateNewScheduleJsonPresenter::class),
                    ]);
                });

            /** Delete Schedule Controller */

            $this->app
                ->when(ApiControllers\Api\Schedule\DeleteScheduleApiController::class)
                ->needs(UseCases\DeleteSchedule\DeleteScheduleInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\DeleteSchedule\DeleteScheduleInteractor::class, [
                        'output' => $app->make(Presenters\Schedule\DeleteSchedule\DeleteScheduleJsonPresenter::class),
                    ]);
                });

            /** Update Work Hour */

            $this->app
                ->when(ApiControllers\Api\WorkHour\UpdateWorkHourApiController::class)
                ->needs(UseCases\UpdateWorkHour\UpdateWorkHourInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\UpdateWorkHour\UpdateWorkHourInteractor::class, [
                        'output' => $app->make(Presenters\WorkHour\UpdateWorkHour\UpdateWorkHourJsonPresenter::class),
                    ]);
                });

            /**Update User Password */

            $this->app
                ->when(ApiControllers\Api\User\UserUpdatePasswordApiController::class)
                ->needs(UseCases\UpdateUser\UpdateUserInputPort::class)
                ->give(function ($app) {
                    return $app->make(UseCases\UpdateUser\UpdateUserInteractor::class, [
                        'output' => $app->make(Presenters\User\UpdateUser\UpdateUserJsonPresenter::class),
                    ]);
                });

        }

        /**
         * Bootstrap any application services.
         */
        public function boot(): void
        {
            //
        }
    }
