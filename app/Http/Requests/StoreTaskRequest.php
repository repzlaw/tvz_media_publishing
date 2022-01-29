<?php

namespace App\Http\Requests;

use App\Http\Requests\ReviewTaskRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'task'=>'required',
            'topic'=>'required',
            'instructions'=>'required',
            'region_target'=>'required',
            'website_id'=>'required',
            'assigned_to'=>'required',
            'task_type'=>'required',
            // 'status'=>'required'
        ];
    }
}
