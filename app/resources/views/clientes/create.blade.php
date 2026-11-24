@extends('layouts.app')

@section('titulo', 'Nuevo cliente')

@section('contenido')
    <h1>Nuevo cliente</h1>

    @if ($errors->any())
        <div class="alerta error" role="alert">Revisa los datos del formulario: hay campos con errores.</div>
    @endif

    <form class="tarjeta" method="POST" action="{{ route('clientes.store') }}" novalidate>
        @csrf

        <label for="nombre">Nombre *</label>
        <input id="nombre" name="nombre" type="text" maxlength="120" value="{{ old('nombre') }}" required>
        @error('nombre') <div class="campo-error">{{ $message }}</div> @enderror

        <label for="tipo">Tipo *</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecciona un tipo</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo') === $tipo)>{{ ucfirst($tipo) }}</option>
            @endforeach
        </select>
        @error('tipo') <div class="campo-error">{{ $message }}</div> @enderror

        <label for="telefono">Teléfono *</label>
        <input id="telefono" name="telefono" type="tel" maxlength="20" value="{{ old('telefono') }}" required>
        @error('telefono') <div class="campo-error">{{ $message }}</div> @enderror

        <div class="acciones">
            <button class="boton" type="submit">Guardar</button>
            <a class="boton secundario" href="{{ route('clientes.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
