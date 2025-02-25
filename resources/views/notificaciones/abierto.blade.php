<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación Leída</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="p-6">
    <h2 class="text-2xl font-bold mb-4">¡Gracias!</h2>
    <p class="mb-4">Hemos registrado que has abierto la notificación.</p>

    @if($detalle->notificacion->archivos->count() > 0)
        <h3 class="text-xl font-semibold mb-2">Archivos adjuntos:</h3>
        <ul class="space-y-2">
            @foreach($detalle->notificacion->archivos as $archivo)
                <li class="flex items-center justify-between bg-gray-100 p-3 rounded">
                    <span>{{ $archivo->file_name }}</span>
                    <a href="{{ route('notificaciones.download', $archivo->id) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Descargar
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
