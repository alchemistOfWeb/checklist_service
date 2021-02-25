<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreAdminRequest extends FormRequest
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
            'roles' => 'array',
            'roles' => 'string',
            'name' => 'required|between:4,64',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|string|between:4,255',
        ];
    }
}
