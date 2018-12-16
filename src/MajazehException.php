<?php

namespace Majazeh\Dashboard;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
class MajazehException extends ExceptionHandler
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        $exp = $this->getRender($request, $exception);
        return $exp;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function getRender($request, Exception $exception)
    {
        if($exception instanceof \Majazeh\Dashboard\MajazehJsonException)
        {
            return $exception->json_response;
        }

        if($exception instanceof \Illuminate\Validation\ValidationException)
        {
            return response()->json(['is_ok' => false, 'message' => 'VALIDATION_ERROR', 'message_text' => _d('VALIDATION_ERROR') , 'errors' => $exception->errors()], 401);
        }
        if($exception instanceof \Symfony\Component\Debug\Exception\FatalThrowableError || $exception instanceof \ErrorException)
        {
            if(env('APP_DEBUG', false))
            {
                return response()->json([
                    'is_ok' => false,
                    'message' => $exception->getMessage(),
                    'message_text' => _d($exception->getMessage()),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ], 500);
            }
            else
            {
                return response()->json(['is_ok' => false, 'message' => 'INTERNALL_ERROR', 'message_text' => _d('INTERNALL_ERROR')], 500);
            }
        }

        if(method_exists($exception, 'getMessage'))
        {
            $message = $exception->getMessage();
            $status = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
            if(!$message)
            {
                switch ($status) {
                    case 404:
                        $message = "NOT_FOUND";
                        break;
                    case 500 :
                        $message = "INTERNALL_ERROR";
                    break;
                }
            }
            return response()->json(['is_ok' => false, 'message' => $message, 'message_text' => _d($message)], $status);
        }
    }
}
