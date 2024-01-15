<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Properties;

use App\Enums\RealEstate\Permissions\PropertiesPermissions;
use App\Enums\RealEstate\PropertyTypes;
use App\Enums\RealEstate\RentTerms;
use App\Models\GeoLocation\Sectors;
use App\Models\Images;
use App\Models\RealEstate\Amenities;
use App\Models\RealEstate\Properties;
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
        return $this->user()->can(PropertiesPermissions::WRITE());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', Rule::in(PropertyTypes::names())],
            'reference' => ['required', 'string', 'alpha_dash',
                Rule::unique(Properties::class)->ignore($this->route('property')),
            ],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'available' => ['required', 'boolean'],

            'bedrooms' => ['required', 'integer'],
            'full_bathrooms' => ['required', 'integer'],
            'half_bathrooms' => ['nullable', 'integer'],

            'lot_area' => ['nullable', 'integer'],
            'construction_area' => ['nullable', 'integer'],

            'construction_year' => ['nullable', 'date_format:Y'],

            'location_id' => ['required', 'integer', Rule::exists(Sectors::class, 'id')],
            'latitude' => ['present', 'nullable', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['present', 'nullable', 'numeric', 'min:-180', 'max:180'],

            'amenities' => ['present', 'array'],
            'amenities.*' => ['required', 'integer', 'distinct', Rule::exists(Amenities::class, 'id')],

            'listings' => ['present', 'nullable', 'array', 'min:1'],
            'listings.*' => ['required', 'string', Rule::in(['RENT', 'SALE'])],

            'listings.SALE' => ['integer', 'min:1'],

            'listings.RENT' => ['array', 'min:1', function ($attribute, $value, $fail) {
                if (array_diff(array_keys($value), RentTerms::names())) {
                    $fail('Invalid rent term');
                }
            }],
            'listings.RENT.*' => ['integer', 'min:1'],

            'images' => ['present', 'array'],
            'images.*.id' => ['required', 'integer', 'distinct', Rule::exists(Images::class, 'id')],
            'images.*.order' => ['required', 'integer', 'min:0', 'distinct'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        /**
         * for some reason using 'nullable' rule in a nested array field
         * and then sending null as the value
         * completely removes that field from the validated()
         * current solution is to re-introduce the field with the sent null value
         */
        return parent::validated() + ['listings' => null];
    }
}
