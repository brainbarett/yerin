<?php

namespace App\Http\Requests\Api\Admin\Admin;

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

	protected function prepareForValidation()
    {
        abort_if($this->user()->id == $this->route('admin')->id, 403, __('messages.cant-delete-self'));
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
}
