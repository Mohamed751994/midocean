<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Services\CrudService;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    use HelperTrait;

    /** Here We Inject Service Class To Uses Its Methods  **/
    public function __construct(protected CommentRepository $commentRepository) {
    }

    /** To Get Items**/
    public function index()
    {
        try {
            $posts = $this->commentRepository->all();
            return $this->successResponse('Comments', $posts);
        }catch (\Exception $e)
        {
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Store Item**/
    public function store(CommentRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->commentRepository->create($request->validated());
            DB::commit();
            return $this->successResponse('Comment Created Successfully...',$post);
        }catch (\Exception $e)
        {
            DB::rollback();
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Show Item**/
    public function show($id)
    {
        try {
            $post = $this->commentRepository->show($id);
            return ($post) ?
                $this->successResponse('Comment Number '.$id, $post) :
                $this->errorResponse('Comment Not Found',400);
        }catch (\Exception $e)
        {
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Update Item**/
    public function update(CommentRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->update($request->validated(), $id);
            DB::commit();
            return $this->successResponse('Comment Updated Successfully...');
        }catch (\Exception $e)
        {
            DB::rollback();
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Delete Item**/
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->delete($id);
            DB::commit();
            return $this->successResponse('Comment Deleted Successfully...');
        }catch (\Exception $e)
        {
            DB::rollback();
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

}
