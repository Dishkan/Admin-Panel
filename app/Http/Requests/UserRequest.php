<?php

namespace App\Http\Requests;

use App\Role;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
		    'password'      => [
			    $this->route()->user ? 'nullable' : 'required',
			    'confirmed',
			    'min:6',
		    ],
		    'profile_photo' => [ 'nullable', 'image' ],
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
        ];
    }
}
