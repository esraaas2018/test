<?php

namespace App\Http\Requests;

use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;

class TaskChangeStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TaskPolicy::assUpdate();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['in:in_progress']
        ];
    }
}
