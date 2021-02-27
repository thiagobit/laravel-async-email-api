<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SendEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emails' => 'required|array',
            'emails.*.email' => 'required|email|max:255',
            'emails.*.subject' => 'required|string|max:255',
            'emails.*.body' => 'required|string',
            'emails.*.attachments' => 'array',
            'emails.*.attachments.*.name' => 'required_with:emails.*.attachments.*.file|string',
            'emails.*.attachments.*.file' => 'required_with:emails.*.attachments.*.name|base64min:1',
        ];
    }
}
