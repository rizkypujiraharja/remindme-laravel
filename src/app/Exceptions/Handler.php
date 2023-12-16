<?php

namespace App\Exceptions;

use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponses;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        dd($e);
        $parent = parent::render($request, $e);
        $debug = config('app.debug');
        $trace = $debug ? $e->getTrace() : [];

        if ($request->expectsJson()) {

            if ($e instanceof CommonErrorException) {
                return $this->errorApiResponse($e->getMessage(), $e->getError(), $e->getCode(), $trace);
            } elseif ($e instanceof ValidationException) {
                throw new BadRequestException($e->validator->errors()->first());
            } elseif ($e instanceof AuthenticationException) {
                $routeName = \Route::currentRouteName();
                if ($routeName === 'refresh_token') {
                    throw new InvalidRefreshTokenException();
                } else {
                    throw new InvalidAccessTokenException();
                }
            } elseif ($e instanceof AuthorizationException) {
                throw new ForbiddenAccessException();
            } elseif ($e->getCode() === 404 || $e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                throw new NotFoundException();
            }
            $message = match (true) {
                default => $e->getMessage() ?: 'An error occurred.',
            };

            return $this->errorApiResponse($message, 'ERR_INTERNAL_ERROR', $parent->getStatusCode(), $trace);
        }

        return $parent;
    }
}
