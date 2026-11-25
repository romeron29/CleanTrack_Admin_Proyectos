<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'CleanTrack') · CleanTrack</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, sans-serif; background: #f4f6f8; color: #1f2933; }
        header { background: #0f766e; color: #fff; padding: .9rem 1rem; }
        header a { color: #fff; text-decoration: none; font-weight: 600; }
        main { max-width: 900px; margin: 0 auto; padding: 1rem; }
        h1 { font-size: 1.4rem; margin: .5rem 0 1rem; }
        .barra { display: flex; flex-wrap: wrap; gap: .5rem; justify-content: space-between; align-items: center; }
        .boton { display: inline-block; background: #0f766e; color: #fff; border: 0; border-radius: 6px; padding: .6rem 1rem; font-size: 1rem; text-decoration: none; cursor: pointer; }
        .boton.secundario { background: #e4e7eb; color: #1f2933; }
        .alerta { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alerta.exito { background: #d1fae5; color: #065f46; }
        .alerta.error { background: #fee2e2; color: #991b1b; }
        .tarjeta { background: #fff; border-radius: 8px; padding: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
        label { display: block; font-weight: 600; margin: .8rem 0 .3rem; }
        input, select { width: 100%; padding: .6rem; font-size: 1rem; border: 1px solid #cbd2d9; border-radius: 6px; }
        .campo-error { color: #b91c1c; font-size: .9rem; margin-top: .25rem; }
        .areas { border: 1px solid #e4e7eb; border-radius: 8px; margin: 1rem 0 0; padding: 0 1rem 1rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 0 1rem; }
        .areas legend { font-weight: 600; padding: 0 .3rem; }
        @media (min-width: 700px) { .areas { grid-template-columns: repeat(4, 1fr); } }
        .oculto { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
        .ficha dl { margin: 0; }
        .ficha .dato { display: flex; justify-content: space-between; gap: 1rem; padding: .6rem 0; border-bottom: 1px solid #e4e7eb; }
        .ficha dt { font-weight: 600; color: #52606d; }
        .ficha dd { margin: 0; text-align: right; overflow-wrap: anywhere; }
        .ficha h2 { font-size: 1.1rem; margin: 1.2rem 0 .6rem; }
        .ficha-areas { display: grid; grid-template-columns: repeat(2, 1fr); gap: .6rem; }
        @media (min-width: 700px) { .ficha-areas { grid-template-columns: repeat(4, 1fr); } }
        .area { background: #f0f4f8; border-radius: 8px; padding: .8rem; text-align: center; }
        .area .cantidad { display: block; font-size: 1.8rem; font-weight: 700; color: #0f766e; }
        .acciones { display: flex; gap: .5rem; margin-top: 1.2rem; flex-wrap: wrap; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { text-align: left; padding: .7rem; border-bottom: 1px solid #e4e7eb; }
        th { background: #f0f4f8; }
        /* En teléfono la tabla se muestra como tarjetas apiladas */
        @media (max-width: 600px) {
            thead { display: none; }
            table, tbody, tr, td { display: block; width: 100%; }
            tr { margin-bottom: .75rem; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
            td { border: 0; padding: .35rem .8rem; }
            td::before { content: attr(data-label) ": "; font-weight: 600; }
        }
    </style>
</head>
<body>
    <header><a href="{{ route('clientes.index') }}">CleanTrack</a></header>
    <main>
        @if (session('exito'))
            <div class="alerta exito" role="status">{{ session('exito') }}</div>
        @endif
        @yield('contenido')
    </main>
</body>
</html>
