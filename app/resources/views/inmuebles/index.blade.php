@extends('layouts.app')

@section('titulo', 'Inmuebles de ' . $cliente->nombre)

@section('contenido')
    <p><a href="{{ route('clientes.index') }}">&larr; Volver a clientes</a></p>

    <div class="barra">
        <h1>Inmuebles de {{ $cliente->nombre }}</h1>
        <a class="boton" href="{{ route('clientes.inmuebles.create', $cliente) }}">Nuevo inmueble</a>
    </div>

    @if ($inmuebles->isEmpty())
        <div class="tarjeta">Este cliente todavía no tiene inmuebles registrados.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Dirección</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inmuebles as $inmueble)
                    <tr>
                        <td data-label="Dirección">{{ $inmueble->direccion }}</td>
                        <td data-label="Tipo">{{ ucfirst($inmueble->tipo) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
