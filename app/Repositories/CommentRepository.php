<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Repositories\CRUD\CrudInterface;
use App\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CommentRepository implements CrudInterface
{
    use HelperTrait;


    /** LOGIC : To Get List of Posts in Paginated **/
    public function all()
    {
        return Comment::with(['post', 'images'])->latest()->paginate($this->paginate);
    }

    /** LOGIC : To Create Comment In DB **/
    public function create($data)
    {
        $comment = Comment::create(Arr::except($data, 'images'));
        if(isset($data['images']))
        {
            foreach($data['images'] as $image)
            {
                $fileUploaded='Upload_'.rand(1,99999999999).'.'.$image->getClientOriginalExtension();
                $image->move('uploads/comments/', $fileUploaded);
                Image::create([
                    'url' => $fileUploaded,
                    'type' => $image->getClientOriginalExtension(),
                    'parentable_id' => $comment->id,
                    'parentable_type' => Comment::class
                ]);
            }
        }
        return $comment;

    }

    /** LOGIC : To Show Comment **/
    public function show($id)
    {
        return Comment::with(['post', 'images'])->find($id);
    }

    /** LOGIC : To Update Post **/
    public function update($data, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(Arr::except($data, 'images'));
        if(isset($data['images']))
        {
            $comment->images()->delete();
            foreach($data['images'] as $image)
            {
                $fileUploaded='Upload_'.rand(1,99999999999).'.'.$image->getClientOriginalExtension();
                $image->move('uploads/posts/', $fileUploaded);
                Image::create([
                    'url' => $fileUploaded,
                    'type' => $image->getClientOriginalExtension(),
                    'parentable_id' => $comment->id,
                    'parentable_type' => Comment::class
                ]);
            }
        }
        return $comment;
    }


    /** LOGIC : To Delete Post With Relations (Comments And Images)**/
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        if(count($comment->images) > 0)
        {
            foreach($comment->images as $image)
            {
                $this->delete_file_before_delete_item('/uploads/comments/'.$image->url);
            }
        }
        $comment->images()->delete();
        $comment->delete();
    }


}
