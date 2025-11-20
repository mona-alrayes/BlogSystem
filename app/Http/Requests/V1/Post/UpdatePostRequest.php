<?php

namespace App\Http\Requests\V1\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::id() == $this->post->user_id;
    }
    
    public function failedAuthorization()
    {
        throw new AccessDeniedHttpException('You are not the author of this post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|min:3|max:255',
            'content' => 'sometimes|required|string|min:10',
            'sub_category_id' => 'sometimes|required|integer|exists:sub_categories,id',
            'user_id' => 'sometimes|integer|exists:users,id',
            'status' => 'sometimes|string|in:draft,published,archived,pending',
        ];
    }
}
