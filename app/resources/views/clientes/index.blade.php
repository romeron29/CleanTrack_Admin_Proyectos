@extends('layouts.app')

@section('titulo', 'Clientes')

@section('contenido')
    <div class="barra">
        <h1>Clientes</h1>
        <a class="boton" href="{{ route('clientes.create') }}">Nuevo cliente</a>
    </div>

    @if ($clientes->isEmpty())
        <div class="tarjeta">Todavía no hay clientes registrados.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Teléfono</th>
                    <th>Inmuebles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td data-label="Nombre">{{ $cliente->nombre }}</td>
                        <td data-label="Tipo">{{ ucfirst($cliente->tipo) }}</td>
                        <td data-label="Teléfono">{{ $cliente->telefono }}</td>
                        <td data-label="Inmuebles">
                            <a href="{{ route('clientes.inmuebles.index', $cliente) }}">Ver inmuebles ({{ $cliente->inmuebles_count }})</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
