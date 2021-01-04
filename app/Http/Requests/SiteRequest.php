<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Site;
use Illuminate\Validation\Rule;

class SiteRequest extends FormRequest
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
		    'type'            => 'required',
		    'dealer_name'     => 'required|max:255',
		    'lead_email'      => [
			    'required',
			    'email',
			    Rule::unique( ( new Site )->getTable() )->ignore( $this->route()->site->id ?? null ),
		    ],
		    'country'         => 'required|max:255',
		    'state'           => 'required|max:255',
		    'city'            => 'required|max:255',
		    'postal_code'     => 'required',
		    'dealer_number'   => [
			    'required',
			    //'regex: /((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/',
			    Rule::unique( ( new Site )->getTable() )->ignore( $this->route()->site->id ?? null ),
		    ],
		    'address'         => 'required|max:255',
		    'place_name'      => 'required|max:255',
		    'old_website_url' => 'required|max:255',
		    'site_icon_src'   => [ 'nullable', 'image' ],
		    'logo_src'        => [ 'nullable', 'image' ],
	    ];
    }
}