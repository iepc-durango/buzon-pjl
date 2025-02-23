<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';




const props = defineProps({
    notificaciones: {
      type: Array,
      default: () => []
    }
  });



</script>

<template>
    
    <AppLayout title="Detalles">
        
        <div class="py-10">
            
        </div>

        

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tabla de detalles -->
            <div class="flex justify-center">
                <div class="relative overflow-x-auto max-w-7xl w-full shadow-md sm:rounded-lg">

                  <Welcome />

                    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-ls text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Notificacion</th>
                                <th scope="col" class="px-6 py-3">Destinatario</th>
                                <th scope="col" class="px-6 py-3">Fecha de Envío</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Recorrer los detalles y mostrar la información -->
                            <tr v-for="notificacion in notificaciones" :key="notificacion.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ notificacion.id  }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ notificacion.tipo_id  }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ notificacion.created_at}}
                                </td>
                                <td class="px-6 py-4">
                                  <a href="/detalles" class="font-medium text-gray-600 dark:text-gray-500 hover:underline">Detalles</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>