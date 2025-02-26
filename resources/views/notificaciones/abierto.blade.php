<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Notificación Abierta</title>
    @vite(['resources/js/app.js'])
</head>
@php
    // Sabiendo que muchas extensiones o mimetypes pueden adoptar el mismo icono como .doc, .docx o .csv, xls, xlsx entonces:
     function icon($filename) {
         $ext = pathinfo($filename, PATHINFO_EXTENSION);
         return match ($ext) {
             'pdf' => 'https://i.imgur.com/5WdGeCO.png',
             'doc', 'docx' => 'https://i.imgur.com/WUhHRqQ.png',
             'zip', 'rar' => 'https://i.imgur.com/ZnI2jNR.png',
             'xlsx', 'xls', 'csv' => 'https://i.imgur.com/DcSJ0zr.png',
             default => 'https://i.imgur.com/cK17fsC.png',
         };
     }
     // Set the locale to Spanish
     Carbon\Carbon::setLocale('es');
@endphp
<body>
<div class="container text-center">
    <img src="https://i.imgur.com/9TJfat5.png" alt="Logo IEPC" width="100">
</div>
<div class="container mx-auto shadow p-6 rounded border border-gray-100 mt-6">
    @if ($detalle->notificacion->archivos->isNotEmpty())
        <h2>Archivos adjuntos:</h2>
        <ul>
            @foreach ($detalle->notificacion->archivos as $archivo)
                <li class="flex border-b border-gray-100 items-center justify-between">
                    <a href="{{ 'https://s3.us-east-1.amazonaws.com/static.appsiepcdurango.mx/' . $archivo->file_path }}" target=":_blank" class="hover:underline text-blue-500 flex space-x-1.5">
                        <img src="{{ icon($archivo->file_name) }}" alt="Icono" width="32" height="32">
                        <span>{{ $archivo->file_name }}</span>
                    </a>
                    <span class="text-gray-500 text-sm">{{ $archivo->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay archivos adjuntos.</p>
    @endif
</div>
<div class="container mx-auto text-center mt-10">
    <div>
        <small class="text-gray-600">INSTITUTO ELECTORAL Y DE PARTICIPACIÓN CIUDADANA DEL ESTADO DE DURANGO - {{ \Carbon\Carbon::now()->year }}</small>
    </div>
    <div>
        <a href="mailto:ut.computo@iepcdurango.mx" class="text-xs text-blue-500 hover:underline">Reportar un error.</a>
    </div>
</div>
</body>
</html>
