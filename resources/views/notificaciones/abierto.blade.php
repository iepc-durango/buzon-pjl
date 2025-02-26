<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación Abierta</title>
</head>
<body>
    <h1>Notificación Abierta</h1>
    <p>La notificación fue abierta.</p>

    @if ($detalle->notificacion->archivos->isNotEmpty())
        <h2>Archivos adjuntos:</h2>
        <ul>
            @foreach ($detalle->notificacion->archivos as $archivo)
                <li>{{ $archivo->file_name }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay archivos adjuntos.</p>
    @endif
</body>
</html>
