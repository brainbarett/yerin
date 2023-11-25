<?php

namespace App\Http\Requests\Api\Admin\RealEstate\Features;

use App\Enums\Permissions\RealEstate\Features as FeaturesPermissions;
use App\Models\RealEstate\Features;
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
		abort(501);
        return $this->user()->can(FeaturesPermissions::WRITE());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique(Features::class)]
        ];
    }
}
