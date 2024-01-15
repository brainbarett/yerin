<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Models\Roles;
use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', Rule::unique(Users::class)->ignore($this->route('user'))],
            'name' => ['required', 'string'],
            'language' => [Rule::in(config('app.accepted_languages'))],
            'role' => [
                Rule::when(
                    $this->updatingSelf,
                    ['missing'],
                    ['present', 'nullable', Rule::exists(Roles::class, 'id')]
                ),
            ],
        ];
    }
}
