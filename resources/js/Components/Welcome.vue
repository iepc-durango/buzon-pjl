<script setup>
import { Link } from '@inertiajs/vue3'


</script>

<template>
    
   
     Contenedor del botón fuera de la tabla
    <div class="flex justify-end py-3 px-4 mb-4">
        <Link
      href="/notificaciones/create"
      class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none shadow-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-1.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
    >
      Crear Notificacion
    </Link>
        </div> 
        
    

</template>