<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\UploadService;
use App\Constants\AppConstant;
use App\Constants\StatusCode;
use Illuminate\Http\Request;

class AdminAjaxController extends Controller
{
    public function __construct(
        private UploadService $uploadService
    ) {}

	public function jsonApi($code, $message = '', $data = [])
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

	/**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImageTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:' . AppConstant::MIME_TYPE_IMAGE . '|max:' . AppConstant::IMAGE_MAXSIZE,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => StatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $images = $this->uploadService->uploadImageTemp($request->file('images'));
        if (!empty($images)) {
            return response()->json([
                'code' => StatusCode::OK,
                'data' => [
                    'images' => $images,
                ],
            ]);
        }

        return response()->json([
            'code'    => StatusCode::BAD_REQUEST,
            'message' => 'Upload fails!',
        ]);
    }

    /**
     * change Status Item
     *
     * @param $id
     * @return Factory|View
     */
    public function changeStatusItem(Request $request)
    {
        if (!$request->model) {
            return false;
        }

        $useModel = str_replace(' ', '', 'App\Models\ ' . $request->model);
        $data = $useModel::find($request->id);
        $data->status = $request->status;

        return $data->save();
    }
}
