<?php

namespace App\Http\Requests;

use App\Role;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CurrentPasswordCheckRule;

class UserRequest extends FormRequest
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
		    'firstname'     => 'required|max:255',
		    'lastname'      => 'required|max:255',
		    'email'         => [
			    'required',
			    'email',
			    Rule::unique( ( new User )->getTable() )->ignore( $this->route()->user->id ?? null ),
		    ],
		    'phonenumber'   => [
			    'required',
			    //'regex: /((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/',
			    Rule::unique( ( new User )->getTable() )->ignore( $this->route()->user->id ?? null ),
		    ],
		    'role_id'       => [
			    'required',
			    'exists:' . ( new Role )->getTable() . ',id',
		    ],
		    'profile_photo' => [ 'nullable', 'image' ],

		    'old_password'  => [ 'required', 'min:6', new CurrentPasswordCheckRule ],

		    'password'      => [ 'required', 'min:6', 'confirmed', 'different:old_password' ],

		    'password_confirmation' => [ 'required', 'min:6' ],
	    ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'role_id' => 'role',
            'old_password' => __('current password'),
        ];
    }
}
