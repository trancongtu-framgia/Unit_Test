<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->canCreateReport()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'string|nullable',
            'link' => 'string|nullable',
            'test_link' => 'string|nullable',
            'subject_id' => 'required|integer|exists:subjects,id',
            'status' => 'string|nullable',
            'day' => 'integer|required',
            'lesson' => 'string|nullable'
        ];
    }
}
