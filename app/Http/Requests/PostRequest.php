<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'title' => 'required|unique:posts,title',
                    'category_id' => 'required',
                    'thumbnail' => 'required|image|mimes:jpg,png,gif,jpeg,svg|max:2048',
                    'content' => 'required',
                ];
                break;
            default:
            return [
                'title' => 'required',
                'category_id' => 'required',
                'thumbnail' => 'image|mimes:jpg,png,gif,jpeg,svg|max:2048',
                'content' => 'required',
            ];
            break;
        }
       
    }
}
