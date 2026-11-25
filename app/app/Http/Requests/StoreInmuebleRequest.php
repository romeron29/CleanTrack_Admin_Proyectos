<?php

namespace App\Http\Requests;

use App\Models\Inmueble;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInmuebleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'direccion' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::in(Inmueble::TIPOS)],
        ];
    }

    public function messages(): array
    {
        return [
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
            'tipo.required' => 'El tipo de inmueble es obligatorio.',
            'tipo.in' => 'El tipo debe ser casa, apartamento, oficina o local.',
        ];
    }
}
