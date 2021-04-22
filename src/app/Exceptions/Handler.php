<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $this->renderable(function (ModelNotFoundException $e) {
            return response()->json(['error' => 'This model does not exist with this specified identifier', 'code' => 404], 404);
        });

        $this->renderable(function (AuthenticationException $e) {
            return response()->json(['error' => 'Unauthenticated', 'code' => 401], 401);
        });

        $this->renderable(function (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => 403], 403);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json(['error' => 'The specified URL cannot be found', 'code' => 404], 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return response()->json(['error' => 'The specified method for this request is invalid', 'code' => 405], 405);
        });

        $this->renderable(function (HttpException $e) {
            return response()->json([$e->getMessage(), $e->getCode()]);
        });

        $this->renderable(function (QueryException $e) {
            $errorCode = $e->errorInfo;

            if ($errorCode == 1451) {
                return response()->json(['error' => 'Cannot remove this resource permanently. It is related to other resources', 'code' => 409], 409);
            }
            return $errorCode;
        });

        $this->renderable(function (TokenMismatchException $e) {
            return redirect()->back()->withInput(request()->input());
        });
    }
}
