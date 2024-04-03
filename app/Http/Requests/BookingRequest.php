<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //TODO add in custom validator for car registrations
    public function rules(): array
    {
        return [
            'name' => 'required:string',
            'registration' => 'required:string',
            'dateTo' => 'required|date_format:d/m/Y',
            'dateFrom' => 'required|date_format:d/m/Y',
        ];
    }
}
