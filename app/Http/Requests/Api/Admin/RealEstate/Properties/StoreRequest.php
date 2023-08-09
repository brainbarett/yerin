<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Properties;

use App\Enums\RealEstate\PropertyTypes;
use App\Enums\RealEstate\RentTerms;
use App\Models\Images;
use App\Models\RealEstate\Properties;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'type' => ['required', 'string', Rule::in(PropertyTypes::names())],
			'reference' => ['required', 'string', 'alpha_dash', Rule::unique(Properties::class)],
			'name' => ['required', 'string'],
			'description' => ['nullable', 'string'],
			'available' => ['required', 'boolean'],

			'bedrooms' => ['required', 'integer'],
			'full_bathrooms' => ['required', 'integer'],
			'half_bathrooms' => ['nullable', 'integer'],

			'lot_area' => ['nullable', 'integer'],
			'construction_area' => ['nullable', 'integer'],
			
			'construction_year' => ['nullable', 'date_format:Y'],

			'listings' => ['nullable', 'array', 'min:1'],
			'listings.*' => ['required', 'string', Rule::in(['RENT', 'SALE'])],

			'listings.SALE' => ['integer', 'min:1'],

			'listings.RENT' => ['array', 'min:1', function($attribute, $value, $fail) {
				if(array_diff(array_keys($value), RentTerms::names())) {
					$fail('Invalid rent term');
				}
			}],
			'listings.RENT.*' => ['integer', 'min:1'],

			'images' => ['nullable', 'array', 'min:1'],
			'images.*.id' => ['required', 'integer', 'distinct', Rule::exists(Images::class, 'id')],
            'images.*.order' => ['required', 'integer', 'min:0', 'distinct'],
        ];
    }
}
