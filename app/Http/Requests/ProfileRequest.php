<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname'   => ['required', 'min:3'],
            'lastname'    => ['required', 'min:3'],
            'phonenumber' => ['required', 'min:3'],
            'email'       => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
            'photo'       => ['nullable', 'image'],
        ];
    }
}
