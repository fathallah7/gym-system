<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    public function render($request, Throwable $e): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        // Handle API requests with JSON responses
        if ($request->is('api/*') || $request->expectsJson()) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions and return consistent JSON responses.
     */
    protected function handleApiException($request, Throwable $e): JsonResponse
    {
        $statusCode = 500;
        $message = 'An error occurred while processing your request.';
        $errors = null;

        // Validation Exception
        if ($e instanceof ValidationException) {
            $statusCode = 422;
            $message = 'The given data was invalid.';
            $errors = $e->errors();
        }
        // Authentication Exception
        elseif ($e instanceof AuthenticationException) {
            $statusCode = 401;
            $message = 'Unauthenticated.';
        }
        // Model Not Found Exception
        elseif ($e instanceof ModelNotFoundException) {
            $statusCode = 404;
            $message = 'Resource not found.';
        }
        // Not Found HTTP Exception
        elseif ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'The requested resource was not found.';
        }
        // HTTP Exception
        elseif ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: $message;
        }
        // General Exception
        else {
            $message = config('app.debug') ? $e->getMessage() : $message;
        }

        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        if (config('app.debug')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }

        return response()->json($response, $statusCode);
    }
}
