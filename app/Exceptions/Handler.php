<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $result = [
            'success' => false,
            'message' => config("app.debug") ? $e->getMessage() : "Something went wrong!"
        ];
        if ($e instanceof QueryException) {
            $result = $this->convertExceptionToArray($e);
            $responseCode = 500;
        } elseif ($e instanceof ValidationException) {
            $responseCode =  Response::HTTP_UNPROCESSABLE_ENTITY;
            $result['data'] = $e->errors();
        } elseif ($e instanceof ModelNotFoundException) {
            $responseCode = Response::HTTP_NOT_FOUND;
        } elseif ($e instanceof NotFoundHttpException) {
            $responseCode = Response::HTTP_NOT_FOUND;
        } elseif ($e instanceof AuthenticationException || $e instanceof AuthorizationException) {
            $responseCode = Response::HTTP_UNAUTHORIZED;
        } elseif ($e instanceof BadRequestException) {
            $responseCode = Response::HTTP_BAD_REQUEST;
        } else {
            if (env('TRACE_DEBUG')) {
                $result = $this->convertExceptionToArray($e);
            }
            $responseCode = $this->getResponseCode($e);
        }
        $result['code'] = $responseCode;
        return response()->json($result, $responseCode);
    }

    public function getResponseCode($e)
    {
        return method_exists($e, 'getStatusCode')
            ? $e->getStatusCode()
            : (!empty($e->getCode()) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
