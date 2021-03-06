<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomer extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'street' => 'required',
            'street_two' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required|numeric',
            'country' => 'required',
            'business_id' => 'required',
            'service_team_geo_area' => 'required',
            'company_type' => 'required'
        ];
    }
}
