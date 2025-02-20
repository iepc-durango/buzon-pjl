<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import { Modal } from 'flowbite';
import axios from 'axios';

const selectedTipo = ref('');
const isInputEnabled = ref(false);

const handleSelectChange = (event) => {
  isInputEnabled.value = event.target.value === 'Otro';
};

// Funciones para mostrar y ocultar los modales
onMounted(() => {
  const $buttonElement = document.querySelector('#button');
  const $linkElement = document.querySelector('#link');
  const $modalElement = document.querySelector('#modal');
  const $modal2Element = document.querySelector('#modal2');
  const $closeButton = document.querySelector('#closeButton');
  const $closeButton2 = document.querySelector('#closeButton2');

  const modalOptions = {
    backdropClasses: '',
  };

  if ($modalElement) {
    const modal = new Modal($modalElement, modalOptions);
    $buttonElement?.addEventListener('click', () => modal.toggle());
    $closeButton?.addEventListener('click', () => modal.hide());
    $linkElement?.addEventListener('click', () => modal.hide());
  }

  if ($linkElement) {
    const modal2 = new Modal($modal2Element, modalOptions);
    $linkElement?.addEventListener('click', () => modal2.toggle());
    $closeButton2?.addEventListener('click', () => modal2.hide());
  }
});
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
            <label for="acuerdo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. acuerdo</label>
            <input
              v-model="formData.nacuerdo"
              type="text"
              id="nacuerdo"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
              required
            />
          </div>

          <div>
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
            <select
              v-model="formData.tipo"
              id="tipo"
              @change="handleSelectChange"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
            >
              <option value="" disabled selected>Selecciona el tipo</option>
              <option value="ACUERDO/RESOLUCÓN">ACUERDO/RESOLUCIÓN</option>
              <option value="PES">PES</option>
              <option value="Otro">Otro</option>
            </select>
          </div>

          <div>
            <label for="especificar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especificar</label>
            <input
              type="text"
              v-model="formData.especificar"
              id="especificar"
              :disabled="!isInputEnabled"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
            />
          </div>
        </div>
        <div>
            <label for="resumen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resumen/descripción</label>
            <textarea
              v-model="formData.resumen"
              id="resumen"
              rows="4"
              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
              placeholder="Escribe tu resumen/descripción aquí"
            ></textarea>
          </div>

        <div class="flex justify-center mt-6">
          <button type="submit" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
            Generar documento
          </button>
        </div>
      </form>
    </section>

    <!-- Modales -->
    <div id="modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <!-- Modal content -->
    </div>

    <div id="modal2" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <!-- Modal content -->
    </div>
  </AppLayout>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        titulo: '',
        sesion: '',
        nacuerdo: '',
        tipo: '',
        especificar: '',
      },
    };
  },
  methods: {
    async submitForm() {
      if (this.formData.tipo === 'Otro' && this.formData.especificar) {
        this.formData.tipo = this.formData.especificar;
      }

      try {

axios({
  url: '/generate-document', //back
  method: 'GET',
  responseType: 'blob',  // archivo binario
})
  .then(response => {
  const blob = response.data;
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'archivo.pdf';  // nombre del archivo 
  link.click();
});

console.log('Documento generado correctamente');
      } catch (error) {
        console.error('Error al generar el documento:', error);
      }
    },
  },
};
</script>