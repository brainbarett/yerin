<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Amenities;

use App\Enums\RealEstate\Permissions\AmenitiesPermissions;
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
        return $this->user()->canAny([AmenitiesPermissions::READ(), PropertiesPermissions::WRITE()]);
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
