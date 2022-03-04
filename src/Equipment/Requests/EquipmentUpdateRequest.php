<?php

namespace AvoRed\Framework\Equipment\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', Rule::unique('equipment')->ignore($this->equipment)],
            'content' => ['required', 'string'],
            'image' => ['image', 'max:3072'],
        ];
    }
}
