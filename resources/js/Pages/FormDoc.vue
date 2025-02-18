<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import { onMounted,ref } from 'vue'
import { Modal } from 'flowbite'
import { createApp } from 'vue'
import { QuillEditor } from '@vueup/vue-quill'

</script>


<template>
    <AppLayout>
      <Head title="Nuevo Correo" />
      <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
        <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nuevo Correo</h1>
  
        <form @submit.prevent="submitForm">
          <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
            <div>
              <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
              <textarea
                v-model="formData.titulo"
                id="titulo"
                rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                placeholder="Escribe tu título aquí..."
              ></textarea>
            </div>
          </div>
  
          <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">
            <div>
              <label for="sesion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sesión</label>
              <input
                v-model="formData.sesion"
                type="text"
                id="sesion"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                required
              />
            </div>
  
            <div>
              <label for="nacuerdo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Expediente</label>
              <input
                v-model="formData.nacuerdo"
                type="text"
                id="nacuerdo"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                required
              />
            </div>
          </div>
  
          <button type="submit" class="btn btn-primary" color="primary">Generar Documento</button>
        </form>
      </section>
    </AppLayout>
  </template>
  
  <script>
  export default {
    data() {
      return {
        formData: {
          titulo: '',
          sesion: '',
          nacuerdo: '', // 🔹 Corregido aquí
        },
      };
    },
    methods: {
      async submitForm() {
        try {
          const response = await axios.post('/generate-from-template', this.formData, {
            responseType: 'blob', // Indicar que la respuesta es un archivo
          });
  
          // Crear un Blob con el archivo recibido
          const blob = new Blob([response.data], {
            type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
          });
  
          // Generar una URL temporal para la descarga
          const link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'documento_generado.docx'; // Nombre del archivo
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link); // Limpiar el DOM
  
          console.log('Documento generado y descargado correctamente');
        } catch (error) {
          console.error('Error al generar documento:', error);
        }
      }
    }
  };
  </script>
  