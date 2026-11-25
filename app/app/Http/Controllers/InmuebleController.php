<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInmuebleRequest;
use App\Models\Cliente;
use App\Models\Inmueble;

class InmuebleController extends Controller
{
    public function index(Cliente $cliente)
    {
        $inmuebles = $cliente->inmuebles()->orderBy('direccion')->get();

        return view('inmuebles.index', [
            'cliente' => $cliente,
            'inmuebles' => $inmuebles,
            'areas' => Inmueble::AREAS,
        ]);
    }

    public function create(Cliente $cliente)
    {
        return view('inmuebles.create', [
            'cliente' => $cliente,
            'tipos' => Inmueble::TIPOS,
            'areas' => Inmueble::AREAS,
        ]);
    }

    public function store(StoreInmuebleRequest $request, Cliente $cliente)
    {
        // El cliente se toma de la ruta, nunca del formulario.
        $cliente->inmuebles()->create($request->validated());

        return redirect()->route('clientes.inmuebles.index', $cliente)
            ->with('exito', 'Inmueble registrado correctamente.');
    }

    public function show(Cliente $cliente, Inmueble $inmueble)
    {
        return view('inmuebles.show', [
            'cliente' => $cliente,
            'inmueble' => $inmueble,
            'areas' => Inmueble::AREAS,
        ]);
    }
}
