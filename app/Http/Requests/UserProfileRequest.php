<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
     * Get the response for a forbidden operation.
     * 
     * @return \Illuminate\Http\Response
     */

    public function forbiddenResponse()
    {
        return response(view('errors.403'), 403);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'         => 'required|email',
            'username'      => 'required|max:15',
            'uploadImage'   => 'image|max:10240'
        ];
    }
}
