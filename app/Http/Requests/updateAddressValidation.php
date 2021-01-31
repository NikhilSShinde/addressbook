<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateAddressValidation extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            //'email'         => 'required|email|unique:address_book',
            'email'         => ['required',Rule::unique('address_book', 'email')->ignore($this->post)],
            'phone'         => 'required|digits:10',
            'zip_code'      => 'required|numeric',
            'city'          => 'required',
            //'slug'          => 'required|min:3|max:255|unique:address_book',
            'slug'          => ['required',Rule::unique('address_book', 'email')->ignore($this->post)],
            'street'        => 'required',
            'profile_image'         => 'required|image|mimes:jpg,png,jpeg,gif,webp,svg|max:307200|dimensions:width=150,height=150',
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions'=>'The image dimension must be 150x150'
        ];
    }
}
