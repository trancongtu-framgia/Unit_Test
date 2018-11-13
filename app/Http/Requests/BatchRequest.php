<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'start_day' => 'required|date',
            'stop_day' => 'required|date',
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'team_id' => 'required|integer|exists:teams,id',
            'type_id' => 'required|integer|exists:types,id',
            'subject_ids' => 'required|array|min:1|exists:subjects,id'
        ];
    }
}
