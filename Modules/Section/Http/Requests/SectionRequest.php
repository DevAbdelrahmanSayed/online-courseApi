<?php

namespace Modules\Section\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ApiValidationHelper;
use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:20',
            'description' => 'required|string|max:255',
        ];

    }
    protected function failedValidation(Validator $validator)
    {
        ApiValidationHelper::failedValidation( $validator);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
