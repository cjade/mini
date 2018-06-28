<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ModelNotFoundException::class,
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
     * @param  \Exception $exception
     * @return void
     */
    public function report (Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     * @return \Illuminate\Http\Response
     */
    public function render ($request, Exception $exception)
    {
        //        if (config('app.debug')) return parent::render($request, $exception);

        return $this->handle($request, $exception);
    }

    /**
     * 异常检测处理
     * @param           $request
     * @param Exception $e
     * @return $this|\Symfony\Component\HttpFoundation\Response
     */
    public function handle ($request, Exception $e)
    {
        $type = $request->header('X-MC-Client-Type');
        if (!in_array($type, config('config.ClientTypes'))) {

            return jsonError(ValidationError, 'X-MC-Client-Type不被允许');
        }


        //token过期
        if ($e instanceof TokenExpiredException) {
            return jsonError(Unauthorized);
        }

        //token错误
        if ($e instanceof JWTException) {
            return jsonError(InvalidToken);
        }

        //提交数据验证
        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors();
            return jsonError(ValidationError, '', $errors);
        }

        //Api异常
        if ($e instanceof ApiException) {
            dd($e->getPrevious());
            dd($e);
            return jsonError($e->getMessage());
        }

        return parent::render($request, $e);
    }



}
