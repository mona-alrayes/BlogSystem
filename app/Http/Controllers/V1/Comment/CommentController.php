<?php

namespace App\Http\Controllers\V1\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\Comment\Comment;
use App\Models\V1\Post\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Comment\CommentResource;
use App\Http\Requests\V1\Comment\StoreCommentRequest;
use App\Http\Requests\V1\Comment\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource for a given post.
     */
    public function index(Post $post)
    {
        $paginator = Comment::where('post_id', $post->id)
            ->with('author')
            ->latest()
            ->paginate(10);

        return self::paginated($paginator, CommentResource::class, 'Comments retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['post_id'] = $post->id;

        $comment = Comment::create($data);

        return self::success(new CommentResource($comment->load('author')), 'Comment created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return self::error(null, 'Comment not found for this post', 404);
        }

        return self::success(new CommentResource($comment->load('author')), 'Comment retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return self::error(null, 'Comment not found for this post', 404);
        }

        $comment->update($request->validated());

        return self::success(new CommentResource($comment->load('author')), 'Comment updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return self::error(null, 'Comment not found for this post', 404);
        }

        $comment->delete();

        return self::success(null, 'Comment deleted successfully', 204);
    }

    /**
     * Backwards-compatible method matching route that calls `destroy`.
     */
    public function delete(Post $post, Comment $comment)
    {
        return $this->destroy($post, $comment);
    }
}
