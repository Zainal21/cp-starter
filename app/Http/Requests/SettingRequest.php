<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'website_name' => 'required',
            'tagline' => 'required',
            'address' => 'required',
            'code_analytic_google' => 'required',
            'description' => 'required',
            'cover' => 'required',
        ];
    }
}
