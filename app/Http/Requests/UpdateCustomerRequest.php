<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email,' . $this->route('customer')->id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:customers,phone,' . $this->route('customer')->id],
            'loyalty_points' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
