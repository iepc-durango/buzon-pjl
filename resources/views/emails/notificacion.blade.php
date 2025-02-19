<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
</head>
<body>
    <h1>{{ $notificacion->titulo }}</h1>
    <p>{{ $notificacion->descripcion }}</p>
    <p><strong>Fecha de la notificación:</strong> {{ $notificacion->fecha }}</p>
</body>
</html>
