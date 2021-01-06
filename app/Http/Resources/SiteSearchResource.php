<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
	    return [
		    'id'        => $this->id,
		    'firstname' => $this->firstname,
		    'type'      => $this->type,
		    'model'     => $this->model,
		    'view_link' => $this->view_link,
	    ];
    }
}
