<?php

namespace App\Http\Controllers\V1;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $mainService;

    public function ajaxValidate(Request $request, $rules)
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

    public function succesResponse(string $message = 'Məlumat əlavə edildi')
    {
        return response(['status' => 'success', 'message' => $message], 200);
    }
}
