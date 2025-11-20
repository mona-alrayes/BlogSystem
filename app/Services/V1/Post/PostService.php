<?php

namespace App\Services\V1\Post;
use App\Models\V1\Post\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
 
    public function createPost($data)
    {
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'sub_category_id' => $data['sub_category_id'],
            'status' => $data['status'],
            'content' => $data['content'],
            'title' => $data['title']
        ]);
        return $post;
    }

}