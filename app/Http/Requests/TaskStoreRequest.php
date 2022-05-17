<?php

namespace App\Http\Requests;

use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TaskPolicy::create(Auth::user(), $this->route()->task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string'],
            'deadline'=>['required','date'],
            'description'=>['nullable','string'],
            'user_id'=>['int','required']
        ];
    }
}
