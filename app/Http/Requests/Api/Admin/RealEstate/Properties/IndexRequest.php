<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Properties;

use App\Enums\RealEstate\Permissions\PropertiesPermissions;
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
        return $this->user()->can(PropertiesPermissions::READ());
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
            'per_page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        return parent::validated() + ['paginate' => false];
    }
}
