<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PatchRequest extends FormRequest
{
    private bool $updatingSelf;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var Users $routeUser */
        $routeUser = $this->route('user');
        $user = $this->user();

        $this->updatingSelf = $user->id == $routeUser->id;

        return $user->roles()->where('super_admin', true)->exists() || $this->updatingSelf;
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
                Rule::requiredIf($this->updatingSelf),
                function ($attribute, $value, $fail) {
                    if (! Hash::check($value, $this->user()->password)) {
                        $fail(__('auth.password'));
                    }
                },
                'exclude',
            ],
            'password' => ['string'],
        ];
    }
}
