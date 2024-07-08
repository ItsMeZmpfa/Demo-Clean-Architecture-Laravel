<?php

    namespace App\Http\Requests\Schedule;

    use Illuminate\Foundation\Http\FormRequest;

    class CreateNewScheduleRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<array>
         */
        public function rules(): array
        {
            return [
                'user_id' => "integer",
                'date' => "string",
                'startTime' => "string",
                'endTime' => "string",
            ];
        }
    }
