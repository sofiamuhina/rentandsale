<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Validation\ValidationException;
use App\Http\ApiResponse;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\GenericException;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $ex
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $ex) {//dirty(
        if ($ex instanceof GenericException) {
            if (Utils::isApi($request)) {
                return $response = ApiResponse::error($ex->getMessage());
            }
        } elseif ($ex instanceof ModelNotFoundException) {
            $modelNameArray = explode("\\", $ex->getModel());
            $model = end($modelNameArray);
            $id = $ex->getIds()[0];
            return ApiResponse::error("The object \"$model\" with id $id is not found", 404);
        } /* elseif ($exception instanceof NotFoundHttpException) {
          } elseif ($this->isHttpException($exception)) {
          } elseif ($exception instanceof FatalThrowableError) {
          } */ elseif ($ex instanceof ValidatorException) {
            if (Utils::isApi($request)) {
                return $response = ApiResponse::error(
                                'Data is not valid', 400
                                , ['errors' => $ex->toArray()
                            ['error_description']]);
            } else {
                return back()->withErrors($ex->getMessageBag());
            }
        } elseif ($ex instanceof ValidationException) {
            if (Utils::isApi($request)) {
                return $response = ApiResponse::error(
                                'Data is not valid', 400
                                , ['errors' => $ex->validator
                                    ->getMessageBag()->toArray()]);
            }
        }

        return parent::render($request, $ex);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

}
