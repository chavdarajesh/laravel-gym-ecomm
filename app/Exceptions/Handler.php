<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\Request as FacadesRequest;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Define custom exception handling logic
        // $this->reportable(function (Throwable $e) {
        //     // Log or report any specific exceptions here if needed
        // });

        // Handle specific exceptions and redirect
        // $this->renderable(function (Exception $e, $request) {
        //     // Check if it's an HTTP exception
        //     // if ($this->isHttpException($e)) {
        //     //     $statusCode = $e->getStatusCode();

        //     //     // Handle specific error codes
        //     //     if (in_array($statusCode, [403, 404, 419, 500, 503, 405])) {
        //     //         // Check if the URL segment is for 'admin'
        //     //         if (FacadesRequest::segment(1) == 'admin') {
        //     //             return redirect()->route('admin.dashboard');
        //     //         }
        //     //         // Check if the URL segment is for 'user'
        //     //         else if (FacadesRequest::segment(1) == 'user') {
        //     //             return redirect()->route('user.dashboard');
        //     //         }
        //     //         // Default redirect to front home page for other cases
        //     //         else {
        //     //             return redirect()->route('front.home');
        //     //         }
        //     //     }
        //     // }

        //     // Return the default parent behavior if no redirection occurs
        //     return parent::render($request, $e);
        // });
    }
}
