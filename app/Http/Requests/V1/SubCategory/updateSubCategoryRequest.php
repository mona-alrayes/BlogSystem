<?php

namespace App\Http\Requests\V1\SubCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $subCategory = $this->route('sub_category');
        $subCategoryId = $subCategory?->id ?? $subCategory;

        return [
            'name' => [
                'sometimes',
                'nullable',
                'string',
                'min:3',
                'max:255',
                Rule::unique('sub_categories', 'name')
                    ->where(function ($query) {
                        return $query->where('category_id', $this->input('category_id'));
                    })
                    ->ignore($subCategoryId),
            ],
            'category_id' => ['sometimes', 'required_with:name', 'integer', 'exists:categories,id'],
            'description' => 'sometimes|nullable|string|min:5|max:2000',
        ];
    }
}
