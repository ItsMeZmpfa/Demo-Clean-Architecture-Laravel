<?php

namespace App\Http\Requests\WorkHour;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkHourRequest extends FormRequest
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
     * @return array<array>
     */
    public function rules()
    {
        return [
            'scheduleId' => "integer",
            'startTime' => "string",
            'endTime' => "string",
        ];
    }
}