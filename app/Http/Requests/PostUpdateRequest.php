<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
        // dd($this->only(['title']));
        // if ($this->title === $this->title) {
            $is_valid_title = 'required';
        // }else {
        //     $is_valid_title = 'required|unique:post,title';
        // }
        return [
            'title' => $is_valid_title,
            'category_id' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,gif,jpeg,svg|max:2048',
            'content' => 'required',
        ];
    }
}
