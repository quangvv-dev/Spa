<?php

namespace App\Exceptions;

use App\Constants\ResponseStatusCode;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * @param           $request
     * @param Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, Exception $exception)
    {
        $data['title'] = '404';
        if ($this->isHttpException($exception)) {
            return response()->view('errors.404', ['data' => $data], 404);
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND,'Không tìm thấy dữ liệu');
        }
        if ($exception instanceof HttpException) {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND,'Không tồn tại đường dẫn');
        }
        return parent::render($request, $exception);// TODO: Change the autogenerated stub
    }

    public function responseApi($code, $message = "", $data = [])
    {
        return response()->json([
            'code'     => $code,
            'messages' => $message,
            'data'     => !empty($data) ? $data : [],
        ], $code);
    }
}
