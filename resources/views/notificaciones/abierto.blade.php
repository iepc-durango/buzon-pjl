<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación Leída</title>
</head>
<body>
    <h2>¡Gracias!</h2>
    <p>Hemos registrado que has abierto la notificación.</p>

    @if($detalle->notificacion->archivos->count())
        <h3>Archivos adjuntos:</h3>
        <ul>
            @foreach($detalle->notificacion->archivos as $archivo)
                <li>
                    <a href="{{ Storage::url($archivo->file_path) }}" target="_blank">
                        {{ $archivo->file_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
