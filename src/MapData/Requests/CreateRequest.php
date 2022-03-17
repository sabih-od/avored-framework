<?php

namespace AvoRed\Framework\MapData\Requests;

use App\Models\MapData;
use AvoRed\Framework\MapData\Controllers\MapDataController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('map_data')->whereNull('deleted_at')],
            'address' => ['required', 'string'],
            'rating' => ['required', 'numeric', 'between:0,5'],
            'phone' => ['min:3', 'max:30'],
            'website' => ['string'],
            'state_code' => ['required', 'string', Rule::in(array_keys(MapData::$states))],
            'image' => ['image', 'max:3072'],
            'map_data_type' => ['required', Rule::in(MapData::$TYPES)],
        ];
    }
}
