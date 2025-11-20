<?php

namespace App\Http\Requests\V1\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        $roleId = $role?->id ?? $role;

        return [
            'name' => [
                'sometimes',
                'required_if:guard_name,null',
                'string',
                'min:2',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'guard_name' => [
                'sometimes',
                'nullable',
                'string',
                'in:web,api,sanctum',
            ],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required_if' => 'Role name is required when updating.',
            'name.unique' => 'This role name already exists.',
            'guard_name.in' => 'Guard name must be one of: web, api, sanctum.',
        ];
    }
}
