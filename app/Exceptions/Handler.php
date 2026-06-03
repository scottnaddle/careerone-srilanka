<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
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
            if ($this->shouldReport($e)) {
                FilamentExceptions::report($e);
            }
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            // Check if the request is a POST and the token is invalid (expired)
            return redirect()->route('token.expired')->with('message', 'Your session has expired. Please try again.');
        }
        return parent::render($request, $exception);
    }



}
