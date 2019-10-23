<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
     public function render($request, Exception $exception)
      {
          if ($exception instanceof \Illuminate\Session\TokenMismatchException)
          {
            //$errors = new \Illuminate\Support\MessageBag(['password' => 'For security purposes, the form expired afte sitting idle for too long, Please try again.']);
            return redirect()
                        ->back()
                        ->withInput( $request->except('password') )
                        ->with([
                          'status' => 'Oops! Your validation token has expired. Please try again',
                          'alert'  => 'danger'
                        ]);
          }
          return parent::render($request, $exception);
      }
}
