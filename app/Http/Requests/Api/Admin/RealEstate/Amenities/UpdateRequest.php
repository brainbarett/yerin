<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Amenities;

use App\Enums\RealEstate\Permissions\AmenitiesPermissions;
use App\Models\RealEstate\Amenities;
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
        return $this->user()->can(AmenitiesPermissions::WRITE());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique(Amenities::class)->ignore($this->route('amenity'))],
        ];
    }
}
