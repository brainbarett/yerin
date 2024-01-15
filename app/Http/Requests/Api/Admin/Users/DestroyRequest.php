<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
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
            //
        ];
    }

    protected function prepareForValidation()
    {
        /** @var Users $routeUser */
        $routeUser = $this->route('user');

        abort_if($this->user()->id == $routeUser->id, 403, __('messages.cant-delete-self'));
    }
}
