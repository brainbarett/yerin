<?php

namespace App\Http\Requests\Api\Admin\Admin;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->roles()->where('super_admin', true)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', Rule::unique(Admin::class)],
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
			'language' => [Rule::in(config('app.accepted_languages'))],
			'role' => ['required', Rule::exists(Roles::class, 'id')]
        ];
    }
}
