<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';





import { defineProps } from 'vue';

// Usamos defineProps para obtener las propiedades que son pasadas al componente
const props = defineProps({
  notificaciones: Array
});


</script>

<template>
    <AppLayout title="Dashboard">
       

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>


      <!-- Contenedor de la tabla -->
      <div class="relative overflow-x-auto shadow-0 py-3 sm:rounded-lg">
        

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabla de detalles -->
            <div class="flex justify-center">
                <div class="relative overflow-x-auto max-w-7xl w-full shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-ls text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Notificacion</th>
                                <th scope="col" class="px-6 py-3">Destinatario</th>
                                <th scope="col" class="px-6 py-3">Fecha de Envío</th>
                                <th scope="col" class="px-6 py-3">Estado de Notificacion</th>
                                <th scope="col" class="px-6 py-3">Estado de Notificacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Recorrer los detalles y mostrar la información -->
                            <tr  v-for="notificacion in notificaciones" :key="notificacion.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ notificacion.tipo_id  }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ detalle.destinatario_id  }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ detalle.created_at}}
                                </td>
                                <td class="px-6 py-4">
                                    {{ detalle.status_abierto }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    </AppLayout>
</template>
