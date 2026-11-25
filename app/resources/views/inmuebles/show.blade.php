@extends('layouts.app')

@section('titulo', 'Ficha del inmueble')

@section('contenido')
    <p><a href="{{ route('clientes.inmuebles.index', $cliente) }}">&larr; Volver a los inmuebles de {{ $cliente->nombre }}</a></p>

    <h1>Ficha del inmueble</h1>

    <article class="tarjeta ficha">
        <dl>
            <div class="dato">
                <dt>Dirección</dt>
                <dd>{{ $inmueble->direccion }}</dd>
            </div>
            <div class="dato">
                <dt>Tipo</dt>
                <dd>{{ ucfirst($inmueble->tipo) }}</dd>
            </div>
            <div class="dato">
                <dt>Cliente</dt>
                <dd>{{ $cliente->nombre }} ({{ ucfirst($cliente->tipo) }}) · {{ $cliente->telefono }}</dd>
            </div>
        </dl>

        <h2>Áreas</h2>
        <div class="ficha-areas">
            @foreach ($areas as $campo => $etiqueta)
                <div class="area">
                    <span class="cantidad">{{ $inmueble->$campo }}</span>
                    {{ $etiqueta }}
                </div>
            @endforeach
        </div>
    </article>
@endsection
