<template>
    <AppLayout title="">
        <Head title="Crear-Notificacion" />


        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
            <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nueva Notificacion</h1>


             <!-- Tipo -->
        <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
          <select v-model="form.tipo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" @change="cambiarTipo">
            <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
              {{ tipo.tipo }}
            </option>
          </select>
        </div>
  
      <form @submit.prevent="form.post(route('notificaciones.store'))">
        <!-- Destinatario -->
        <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Destinatario</label>
          <select v-model="form.destinatario_id" class="w-full border rounded">
            <option v-for="destinatario in destinatarios" :key="destinatario.id" :value="destinatario.id">
              {{ destinatario.nombre }}
            </option>
          </select>
        </div>
  
       
  
        <!-- Campos para "Acuerdo" -->
        <div v-if="tipoSeleccionado === 'Acuerdo'" >
          <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
            <input v-model="form.titulo" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" />
          </div>
          <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de Acuerdo</label>
            <input v-model="form.no_acuerdo" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Sesión</label>
            <input v-model="form.sesion" type="text" class="w-full border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Descripción</label>
            <QuillEditor v-model:content="form.descripcion" contentType="html" theme="snow" class="bg-white border rounded p-2" toolbar="full"/>
          </div>
        </div>



  
        <!-- Campos para "PES" -->
        <div v-if="tipoSeleccionado === 'PES'">
          <div class="mb-4">
            <label class="block text-sm font-medium">Número de Expediente</label>
            <input v-model="form.no_expediente" type="text" class="w-full border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Denunciante</label>
            <input v-model="form.denunciante" type="text" class="w-full border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Denunciado</label>
            <input v-model="form.denunciado" type="text" class="w-full border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Municipio</label>
            <select v-model="form.municipio" class="w-full border rounded">
              <option v-for="municipio in municipios" :key="municipio" :value="municipio">
                {{ municipio }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Descripción del Fundamento</label>
            <QuillEditor v-model:content="form.descripcion_fundamento" contentType="html" theme="snow" class="bg-white border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Descripción del Documento</label>
            <QuillEditor v-model:content="form.descripcion_docu" contentType="html" theme="snow" class="bg-white border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Fragmento del Documento</label>
            <QuillEditor v-model:content="form.frag_doc" contentType="html" theme="snow" class="bg-white border rounded p-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Descripción del Notificado</label>
            <QuillEditor v-model:content="form.descripcion_notificado" contentType="html" theme="snow" class="bg-white border rounded p-2" />
          </div>
        </div>
  
        
        <button type="submit" class="bg-gray-500 text-black px-4 py-2 rounded">Crear Notificación</button>
      </form>
    </section>
</AppLayout>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { QuillEditor } from '@vueup/vue-quill';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import '@vueup/vue-quill/dist/vue-quill.snow.css';
  
  const props = defineProps({
    tipos: Array,
    destinatarios: Array,
    municipios: Array
  });
  
  const form = useForm({
    destinatario_id: '',
    tipo_id: '',
    titulo: '',
    descripcion: '',
    descripcion_fundamento: '',
    descripcion_docu: '',
    frag_doc: '',
    descripcion_notificado: '',
    sesion: '',
    no_acuerdo: '',
    denunciante: '',
    denunciado: '',
    no_expediente: '',
    municipio: ''
  });
  
  const tipoSeleccionado = computed(() => {
    const tipo = props.tipos.find(t => t.id === form.tipo_id);
    return tipo ? tipo.tipo : '';
  });
  
  function cambiarTipo() {
    form.titulo = '';
    form.descripcion = '';
    form.descripcion_fundamento = '';
    form.descripcion_docu = '';
    form.frag_doc = '';
    form.descripcion_notificado = '';
    form.sesion = '';
    form.no_acuerdo = '';
    form.denunciante = '';
    form.denunciado = '';
    form.no_expediente = '';
    form.municipio = '';
  }
  </script>
  