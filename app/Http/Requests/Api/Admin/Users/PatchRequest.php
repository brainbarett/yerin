<?php

namespace App\Http\Requests\Api\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PatchRequest extends FormRequest
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
			'old_password' => [
				Rule::requiredIf($this->route('user')->id == $this->user()->id),
				function ($attribute, $value, $fail) {
					if(!Hash::check($value, $this->user()->password)) {
						$fail(__('auth.password'));
					}
				},
				'exclude'
			],
            'password' => ['string'],
        ];
    }
}
