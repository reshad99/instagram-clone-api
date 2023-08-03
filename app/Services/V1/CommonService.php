<?php


namespace App\Services\V1;

use App\Http\Resources\Mobile\UserResource;
use App\Models\User;
use App\Repositories\DefaultModelInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Tymon\JWTAuth\JWTGuard;

abstract class CommonService
{
    /**
     * @var array
     * */
    protected $requestCapture;
    protected $rules;
    protected $updateRules;
    protected $fields;
    protected $driverGuard;

    protected LoggerInterface $channel;


    /**
     * @var DefaultModelInterface
     * */
    protected $mainRepository;

    public function __construct(DefaultModelInterface $mainRepository = null, array $request = [], $logChannel = '')
    {
        $this->channel = Log::channel($logChannel);
        $this->mainRepository = $mainRepository;
        $this->requestCapture = $request;
        $this->driverGuard = 'driver';
    }

    protected function process(callable $callback)
    {
        $rData = $this->requestCaptureEjector();
        try {
            DB::beginTransaction();
            $model = $callback($rData);
            DB::commit();
            return $model;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine());
            throw $exception;
        }
    }

    protected function requestCaptureEjector(): array
    {
        return $this->requestCapture;
    }

    protected function setRequestCapture(array $capture)
    {
        $this->requestCapture = $capture;
    }

    public function validate(Request $request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function errorResponse(Exception $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json(['status' => 'error', 'message' => 'Məlumatları düzgün daxil edin', 'errors' => $e->validator->errors()], 422);
        }
        return response(['status' => 'error', 'message' => $e->getMessage()], 400);
    }

    public function successResponse(string $message = 'Məlumat əlavə edildi')
    {
        return response(['status' => 'success', 'message' => $message], 200);
    }

    public function dataResponse(string $message = 'Məlumat əlavə edildi', $data = null)
    {
        return response(['status' => 'success', 'message' => $message, 'data' => $data], 200);
    }

    public function simpleDataResponse($data = null)
    {
        return response(['status' => 'success', 'data' => $data], 200);
    }

    public function fetchResponse($count = 0, $data = null)
    {
        return response(['status' => 'success', 'count' => $count, 'data' => $data], 200);
    }

    public function infoLogging($message)
    {
        $this->channel->info($message);
    }

    public function errorLogging($message)
    {
        $this->channel->error($message);
    }

    public function driverAuth(): JWTGuard
    {
        return auth()->guard($this->driverGuard);
    }

    public function driverUser(): Authenticatable
    {
        return $this->driverAuth()->user();
    }
}
