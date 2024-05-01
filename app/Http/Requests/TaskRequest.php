<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'task_name' => 'required|max:30|min:2|regex:/^[a-zA-Z0-9\s]*$/',
            'task_description' => 'required|min:2|max:255',
            'task_end_date' => 'required',
            'task_status' => 'required',
            'task_member' => 'required',
            'uuid' => '',
            'company_id' => ''
        ];
    }
    public function messages()
    {
        return [
            'task_name.required' => __('message.required'),
            'task_name.max' => __('message.max'),
            'task_name.min' => __('message.min'),
            'task_name.regex' => __('message.alphanumeric'),
            'task_description.required' => __('message.required'),
            'task_description.max' => __('message.max'),
            'task_description.min' => __('message.min'),
            'task_end_date.required' => __('message.required'),
            'task_status.required' => __('message.required'),
            'project_member.required' => __('message.required'),
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'task_end_date' => $this->extractStartDate($this->task_end_date),
            'company_id' => $this->user()->company_id,
            'uuid' => Str::uuid(),
        ]);
    }
    protected function extractStartDate($dateRange)
    {
        return Carbon::createFromFormat('m/d/Y',$dateRange)->format('Y-m-d');
    }
}
