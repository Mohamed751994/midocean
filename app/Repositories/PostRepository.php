<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Post;
use App\Repositories\CRUD\CrudInterface;
use App\Traits\HelperTrait;
use Illuminate\Support\Arr;

class PostRepository implements CrudInterface
{
    use HelperTrait;


    /** LOGIC : To Get List of Posts in Paginated **/
    public function all()
    {
        return Post::with(['comments', 'images'])->latest()->paginate($this->paginate);
    }

    /** LOGIC : To Create Post In DB **/
    public function create($data)
    {
        $post = Post::create(Arr::except($data, 'images'));
        if(isset($data['images']))
        {
            $this->upload_multiple_images_in_model($data,Post::class, $post->id,'uploads/posts/', 'Post');
        }
        return $post;

    }

    /** LOGIC : To Show Post **/
    public function show($id)
    {
        return Post::with(['comments', 'images'])->find($id);
    }

    /** LOGIC : To Update Post **/
    public function update($data, $id)
    {
        $post = Post::findOrFail($id);
        $post->update(Arr::except($data, 'images'));
        if(isset($data['images']))
        {
            $post->images()->delete();
            $this->upload_multiple_images_in_model($data,Post::class, $post->id,'uploads/posts/', 'Post');
        }
        return $post;
    }


    /** LOGIC : To Delete Post With Relations (Comments And Images)**/
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->comments()->delete();
        if(count($post->images) > 0)
        {
            foreach($post->images as $image)
            {
                $this->delete_file_before_delete_item('/uploads/posts/'.$image->url);
            }
        }
        $post->images()->delete();
        $post->delete();
    }


}
