<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function getHttpExceptionView(HttpExceptionInterface $exception)
    {
        if(request()->is('admin/*')){
            $adminErrorView = "admin.errors.{$exception->getStatusCode()}";
            if (view()->exists($adminErrorView)) {
                return $adminErrorView;
            }
        } else {
            $userErrorView = "participant.errors.{$exception->getStatusCode()}";
            if (view()->exists($userErrorView)) {
                return $userErrorView;
            }
        }

        return "errors::{$exception->getStatusCode()}";
    }
}
