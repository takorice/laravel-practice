<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title'   => 'required|max:255',
            'task'    => 'nullable|max:1000',
            // 'task_status_id' => 'nullable|exists:task_statuses,id',
        ];
    }

    public function attributes()
    {
        return [
            'title'   => 'タイトル',
            'task'    => 'タスク',
            // 'task_status_id' => '',
        ];
    }
}
