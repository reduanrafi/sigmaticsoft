<?php

namespace App\Http\Requests\Api\V1\BedtimeStories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'progress' => 'required|integer|min:0|max:100',
        ];
    }
}
