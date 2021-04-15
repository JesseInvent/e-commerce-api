<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json(["errors" => "Model not found"], Response::HTTP_BAD_REQUEST);
            }
            else if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json(["errors" => "Invalid route"], Response::HTTP_BAD_REQUEST);
            }
        });
    }
}
