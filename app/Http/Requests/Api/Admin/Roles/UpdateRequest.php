<?php

namespace App\Http\Requests\Api\Admin\Roles;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique(Roles::class)->ignore($this->route('role'))],
            'permissions' => ['present', 'nullable', 'array'],
            'permissions.*' => ['required', 'distinct', 'string', Rule::exists(Permissions::class, 'name')],
        ];
    }
}
