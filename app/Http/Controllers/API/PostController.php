<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\CrudService;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    use HelperTrait;

    /** Here We Inject Service Class To Uses Its Methods  **/
    public function __construct(protected PostRepository $postRepository) {
    }

    /** To Get Items**/
    public function index()
    {
        try {
            $posts = $this->postRepository->all();
            return $this->successResponse('Posts', $posts);
        }catch (\Exception $e)
        {
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Store Item**/
    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->create($request->validated());
            DB::commit();
            return $this->successResponse('Post Created Successfully...',$post);
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
            $post = $this->postRepository->show($id);
            return ($post) ?
                $this->successResponse('Post Number '.$id, $post) :
                $this->errorResponse('Post Not Found',400);
        }catch (\Exception $e)
        {
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

    /** To Update Item**/
    public function update(PostRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->postRepository->update($request->validated(), $id);
            DB::commit();
            return $this->successResponse('Post Updated Successfully...');
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
            $this->postRepository->delete($id);
            DB::commit();
            return $this->successResponse('Post Deleted Successfully...');
        }catch (\Exception $e)
        {
            DB::rollback();
            return $this->errorResponse('Error in Code : '.$e,500);
        }
    }

}
