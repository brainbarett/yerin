<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Models\Roles;
use App\Models\Users;
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
		$user = $this->user();

        return $user->roles()->where('super_admin', true)->exists() || $user->id == $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', Rule::unique(Users::class)->ignore($this->route('user')->id)],
            'name' => ['required', 'string'],
			'language' => [Rule::in(config('app.accepted_languages'))],
			'role' => [
				Rule::when(
					$this->route('user')->id == $this->user()->id,
					['missing'],
					['present', 'nullable', Rule::exists(Roles::class, 'id')]
				)
			]
        ];
    }
}
