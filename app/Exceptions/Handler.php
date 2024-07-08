<?php

    namespace App\Exceptions;

    use App\Exceptions\Base\Error;
    use App\Exceptions\Format\DateWrongFormatException;
    use App\Exceptions\Format\InputValidationException;
    use App\Exceptions\User\UserNotFoundException;
    use Carbon\Exceptions\InvalidFormatException;
    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Database\QueryException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use Symfony\Component\HttpFoundation\Response;
    use Throwable;

    class Handler extends ExceptionHandler
    {
        /**
         * The list of the inputs that are never flashed to the session on validation exceptions.
         *
         * @var array<int, string>
         */
        protected $dontFlash = [
            'current_password',
            'password',
            'password_confirmation',
        ];

        /**
         * Register the exception handling callbacks for the application.
         */
        public function register(): void
        {
            $this->renderable(function (ValidationException $exception, $request) {
                if (!$request->wantsJson()) {
                    // tell Laravel to handle as usual
                    return null;
                }

                return new JsonResponse([
                    'message' => 'Validation Errors',
                    'status' => false,
                    'errors' => $exception->validator->errors()->all(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            });
        }


        public function render($request, Throwable $e): Response
        {
            if ($e instanceof InvalidFormatException) {
                $exceptionDateInput = new DateWrongFormatException();
                $replacement = [
                    "message" => collect($e->getMessage()),
                ];

                $error = new Error(
                    help: $exceptionDateInput->help(),
                    error: $exceptionDateInput->error(),
                );
                return response($error->toArray(), $exceptionDateInput->errorCode());
            }
            /** Catch the Validation Error From Formrequest */
            if ($e instanceof ValidationException && $request->is('api/*')) {
                $exceptionInput = new InputValidationException();
                $replacement = [
                    "message" => collect($e->getMessage()),
                ];
                $error = new Error(
                    help: $exceptionInput->help(),
                    error: $exceptionInput->error(),
                );

                return response($error->toArray(), $exceptionInput->errorCode());
            }


            if ($e instanceof QueryException && $request->is('api/*')) {
                $exceptionData = new UserNotFoundException();
                $replacement = [
                    "message" => collect($e->getMessage()),
                ];

                $error = new Error(
                    help: $exceptionData->help(),
                    error: $exceptionData->error(),
                );

                return response($error->toArray(), $exceptionData->errorCode());
            }
            return parent::render($request, $e);
        }

        protected function unauthenticated($request, AuthenticationException $ex)
        {

            if ($request->is('api/*')) { // for routes starting with `/api`
                return response()->json(['success' => false, 'message' => $ex->getMessage()], 401);
            }

            return redirect('/login'); // for normal routes
        }
    }
