<?php

namespace App\Http\Requests\Api\Admin\Admin;

use App\Models\Admin;
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
            'email' => ['required', 'string', 'email', Rule::unique(Admin::class)->ignore($this->route('admin')->id)],
            'name' => ['required', 'string'],
            'password' => ['string'],
			'language' => [Rule::in(config('app.accepted_languages'))],
        ];
    }
}
