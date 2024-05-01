<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectRequest extends FormRequest
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
            'project_name' => 'required|max:30|min:2|regex:/^[a-zA-Z0-9\s]*$/',
            'project_description' => 'required|min:2|max:255',
            'project_start_date' => 'required',
            'project_end_date' => 'required',
            'project_manager' => 'required',
            'project_member' => 'required',
            'uuid' => '',
            'company_id' => ''
        ];
    }
    public function messages()
    {
        return [
            'project_name.required' => __('message.required'),
            'project_name.max' => __('message.max'),
            'project_name.min' => __('message.min'),
            'project_name.regex' => __('message.alphanumeric'),
            'project_description.required' => __('message.required'),
            'project_description.max' => __('message.max'),
            'project_description.min' => __('message.min'),
            'project_start_date.required' => __('message.required'),
            'project_end_date.required' => __('message.required'),
            'project_manager.required' => __('message.required'),
            'project_member.required' => __('message.required'),
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'project_start_date' => $this->extractStartDate($this->project_start_date),
            'project_end_date' => $this->extractEndDate($this->project_start_date),
            'company_id' => $this->user()->company_id,
            'uuid' => Str::uuid(),
        ]);
    }

    protected function extractStartDate($dateRange)
    {
        return Carbon::createFromFormat('m/d/Y',explode(' - ', $dateRange)[0])->format('Y-m-d');
    }

    protected function extractEndDate($dateRange)
    {
        return Carbon::createFromFormat('m/d/Y',explode(' - ', $dateRange)[1])->format('Y-m-d');
    }
}
