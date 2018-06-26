<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //xxxxxx
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

    // 新添加的handle函数
    public function handle ($request, Exception $e)
    {

        $type = $request->header('X-MC-Client-Type');
//        if (!in_array($type, config('config.ClientTypes'))) {
//            return response()->json('X-MC-Client-Type');
//        }

        // 只处理自定义的APIException异常
        if ($e instanceof ApiException) {
            list($message, $code) = explode('-', $e->getMessage());
            $result = [
                "message"     => $message,
                "status_code" => $e->getCode() ?: $code,
            ];
            return response()->json($result);
        }

        if ($e instanceof ValidationException) {
            $errors = $e->errors();
            $result = [
                "message"     => $e->getMessage(),
                "status_code" => $e->getCode(),
            ];
            return response()->json($errors);
        }
        return parent::render($request, $e);
    }
}
