<?php

namespace Modules\File\Http\Requests;

use App\Helpers\ApiValidationHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fileUrl' => 'required|file|mimes:pdf,doc,docx',
            'section_id' => 'required|Integer|exists:sections,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        ApiValidationHelper::failedValidation($validator);
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
