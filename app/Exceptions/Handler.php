<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        $this->renderable(function(ValidationException $e){
            return response(['success' => false, 'statusCode' => 422, 'message' => 'Məlumatlar düzgün deyil', 'errors' => $e->errors()], 422);
        });

        $this->renderable(function(AuthenticationException $e){
            return response(['success' => false,'statusCode' => 401, 'message' => 'Hesaba daxil olmamısınız'], 401);
        });

        $this->renderable(function(NotFoundHttpException $e){
            return response(['success' => false, 'statusCode' => 404, 'message' => 'Belə bir səhifə tapılmadı'], 404);
        });

        $this->renderable(function(ModelNotFoundException $e){
            return response(['success' => false, 'statusCode' => 404, 'message' => 'Belə bir məlumat tapılmadı'], 404);
        });

        $this->renderable(function(Exception $e){
            return response(['success' => false, 'statusCode' => 400, 'message' => $e->getMessage()], 400);
        });
    }
}
