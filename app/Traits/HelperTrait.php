<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

Trait HelperTrait
{
    public $paginate =   50; //Custom Paging


    /*** Success Response ***/
    public function successResponse($message = '',$data = [],$statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /*** Error Response ***/
    public function errorResponse($message = '',$statusCode)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ],$statusCode);
    }

    /*** Upload File (Image , File) ***/
    public function UploadFile($request, $fileInputName, $moveTo)
    {
        $file = $request->file($fileInputName);
        $fileUploaded='Upload_'.rand(1,99999999999).'.'.$file->getClientOriginalExtension();
        $file->move($moveTo, $fileUploaded);
        return $fileUploaded;
    }

    /*** Return full path of image or file ***/
    public function full_path_of_file($image)
    {
        return asset('/uploads/'. $image);
    }

    /*** delete file from path ***/
    public function delete_file_before_delete_item($path)
    {
        $path = public_path($path);
        if (file_exists($path)) {
            File::delete($path);
        }
    }



}
