<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Http\Request;
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
        // Handle all authorization related exceptions
        $this->renderable(function (Throwable $e) {
            if ($e instanceof AuthorizationException ||
                $e instanceof AccessDeniedHttpException ||
                $e instanceof \ArgumentCountError) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'No tienes permisos para realizar esta acción.'
                ], 403);
            }
        });
    }

    /**
     * Prepare exception for rendering.
     */
    protected function prepareException(Throwable $e)
    {
        if ($e instanceof AuthorizationException) {
            return new AccessDeniedHttpException('No tienes permisos para realizar esta acción.', $e);
        }

        return parent::prepareException($e);
    }
}
