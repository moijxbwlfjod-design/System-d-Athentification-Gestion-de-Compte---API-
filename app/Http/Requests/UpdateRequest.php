<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:3|max:50',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|min:8|max:50',
            'gender' => 'sometimes|in:male,female'
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator){
            if(empty($this->all())){
                $validator->errors()->add('fields', 'At lest, one field must be provided.');
            }
        });
    }
}
