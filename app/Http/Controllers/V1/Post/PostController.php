<?php

namespace App\Http\Controllers\V1\Post;

use App\Models\V1\Post\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Post\StorePostRequest;
use App\Http\Resources\V1\Post\PostResource;
use App\Services\V1\Post\PostService;

class PostController extends Controller
{
    protected $PostService;
    public function __construct(PostService $PostService)
    {
        $this->PostService = $PostService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 
        $posts = Post::where('sub_category_id', $request->sub_category_id)->get();
        return self::paginated(PostResource::collection($posts), 'posts been retrived successfully' , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return self::success(new PostResource($this->PostService->createPost($request->validated())), 'post been created successfully' , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return self::success(new PostResource($post), 'post been retrived successfully' , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->validated());
        return self::success(new PostResource($post), 'post been updated successfully' , 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return self::success(null, 'post been deleted successfully' , 204);
    }
}
