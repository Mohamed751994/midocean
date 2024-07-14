<?php

namespace App\Traits;

use App\Models\Image;
use App\Models\Post;
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
    public function upload_multiple_images_in_model($data,$modelClass, $modelID,$moveTo, $modelName)
    {
        foreach($data['images'] as $image)
        {
            $fileUploaded=$modelName.'_'.rand(1,99999999999).'.'.$image->getClientOriginalExtension();
            $image->move($moveTo, $fileUploaded);
            Image::create([
                'url' => $fileUploaded,
                'type' => $image->getClientOriginalExtension(),
                'parentable_id' => $modelID,
                'parentable_type' => $modelClass
            ]);
        }
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
