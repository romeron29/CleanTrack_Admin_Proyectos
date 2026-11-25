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

    /**
     * Un área que se deja vacía se registra como 0.
     */
    protected function prepareForValidation(): void
    {
        $areas = [];

        foreach (array_keys(Inmueble::AREAS) as $area) {
            if ($this->input($area) === null || $this->input($area) === '') {
                $areas[$area] = 0;
            }
        }

        $this->merge($areas);
    }

    public function rules(): array
    {
        $reglas = [
            'direccion' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::in(Inmueble::TIPOS)],
        ];

        foreach (array_keys(Inmueble::AREAS) as $area) {
            $reglas[$area] = ['required', 'integer', 'min:0', 'max:999'];
        }

        return $reglas;
    }

    public function messages(): array
    {
        return [
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
            'tipo.required' => 'El tipo de inmueble es obligatorio.',
            'tipo.in' => 'El tipo debe ser casa, apartamento, oficina o local.',
            '*.integer' => 'El número de :attribute debe ser un número entero.',
            '*.min' => 'El número de :attribute no puede ser negativo.',
            '*.max' => 'El número de :attribute no puede ser mayor que 999.',
        ];
    }

    public function attributes(): array
    {
        return array_map('mb_strtolower', Inmueble::AREAS);
    }
}
