<script setup>
import { Link } from '@inertiajs/vue3'


// const props = defineProps({
//   notificaciones: {
//     type: Array,
//     default: () => []
//   },
// });


</script>

<template>
    
   
    
    <div class="flex justify-end py-3 px-4 mb-6">
        <Link
      href="/notificaciones/create"
      class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none shadow-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
    >
      Crear Notificacion
    </Link>
        </div> 


        
  <!-- <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Listado de Notificaciones</h1>
    <ul>
      <li v-for="notificacion in notificaciones" :key="notificacion.id">
        <strong>ID:</strong> {{ notificacion.id }} -
        <strong>Título:</strong> {{ notificacion.titulo }} -
        <strong>Creado:</strong> {{ notificacion.created_at }}
      </li>
    </ul>
  </div> -->

 
</template>


        
    

