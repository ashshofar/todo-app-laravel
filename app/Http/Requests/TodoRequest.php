<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
    public static function rules()
    {
        return [
            'name'          => 'required|max:500',
            'location'      => 'required|max:273',
            'time_start'    => 'required|date_format:d-m-Y h:i:s',
            'priority'      => 'numeric|max:2',
            'status'        => 'digits_between:1,2'
        ];
    }   
}
