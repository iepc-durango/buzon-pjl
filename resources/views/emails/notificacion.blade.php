<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nueva Notificación</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-md">
    <img src="/img/logo.jpeg" alt="Logo" class="mx-auto w-16 h-16 mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Nueva Notificación</h2>
    <p class="text-gray-600 mt-4">Estimado usuario,</p>
    <p class="text-gray-600 mt-2">
      Se ha generado una nueva notificación. Adjuntamos el documento correspondiente.
    </p>
    <p class="text-gray-600 mt-2">
      Para confirmar que has leído la notificación, haz clic en el siguiente enlace:
    </p>
    <p class="mt-4">
      <a href="{{ $link }}" class="text-blue-600 hover:underline">Marcar Notificación como Leída</a>
    </p>
    <p class="text-gray-600 mt-6">Saludos,</p>
    <p class="text-gray-600">El equipo de Notificaciones</p>
  </div>
</body>
</html>
