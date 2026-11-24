<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:120'],
            'tipo' => ['required', Rule::in(Cliente::TIPOS)],
            'telefono' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 120 caracteres.',
            'tipo.required' => 'El tipo de cliente es obligatorio.',
            'tipo.in' => 'El tipo debe ser residencial o comercial.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'telefono.regex' => 'El teléfono solo puede contener números, espacios, +, - y paréntesis.',
        ];
    }
}
