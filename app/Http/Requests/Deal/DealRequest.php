<?php

namespace App\Http\Requests\Deal;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
             'stage' => 'required|string',
               'accName' => 'required|string',
               'accSite'  => 'required|string',
               'accPhone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/',
        ];
    }
}
