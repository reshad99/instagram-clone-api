<?php

namespace App\Http\Controllers\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function togglePublish(Request $request): JsonResponse
    {
        try {
            $cmid = $request->cmid;
            $class = $request->classPath;

            $model = $class::find($cmid);
            $model->is_published = !$model->is_published;
            $model->save();

            return response()->json([
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 204,
                'message'   => $e->getMessage()
            ]);
        }
    }
}
