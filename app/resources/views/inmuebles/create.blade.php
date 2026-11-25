@extends('layouts.app')

@section('titulo', 'Nuevo inmueble')

@section('contenido')
    <h1>Nuevo inmueble</h1>
    <p>Cliente: <strong>{{ $cliente->nombre }}</strong></p>

    @if ($errors->any())
        <div class="alerta error" role="alert">Revisa los datos del formulario: hay campos con errores.</div>
    @endif

    <form class="tarjeta" method="POST" action="{{ route('clientes.inmuebles.store', $cliente) }}" novalidate>
        @csrf

        <label for="direccion">Dirección *</label>
        <input id="direccion" name="direccion" type="text" maxlength="255" value="{{ old('direccion') }}" required>
        @error('direccion') <div class="campo-error">{{ $message }}</div> @enderror

        <label for="tipo">Tipo *</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecciona un tipo</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo') === $tipo)>{{ ucfirst($tipo) }}</option>
            @endforeach
        </select>
        @error('tipo') <div class="campo-error">{{ $message }}</div> @enderror

        <fieldset class="areas">
            <legend>Áreas</legend>
            @foreach ($areas as $campo => $etiqueta)
                <div>
                    <label for="{{ $campo }}">{{ $etiqueta }}</label>
                    <input id="{{ $campo }}" name="{{ $campo }}" type="number" min="0" max="999" step="1"
                           inputmode="numeric" value="{{ old($campo, 0) }}">
                    @error($campo) <div class="campo-error">{{ $message }}</div> @enderror
                </div>
            @endforeach
        </fieldset>

        <div class="acciones">
            <button class="boton" type="submit">Guardar</button>
            <a class="boton secundario" href="{{ route('clientes.inmuebles.index', $cliente) }}">Cancelar</a>
        </div>
    </form>
@endsection
