<?php

namespace App\Http\Requests;

use App\Models\PersonalTask;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PersonalTaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      $task =$this->route('personal_task');
        return ($task->user_id == Auth::id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'required|max:255',
            'deadline'=>'nullable|date'
        ];
    }

}
