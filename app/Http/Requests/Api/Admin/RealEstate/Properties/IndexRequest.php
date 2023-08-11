<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Properties;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
			'search' => ['nullable', 'string'],
            'paginate' => ['boolean'],
            'page' => ['required_if:paginate,true', 'integer', 'min:1'],
        ];
    }

	public function validated($key = null, $default = null)
    {
        return parent::validated() + ['paginate' => false];
    }
}
