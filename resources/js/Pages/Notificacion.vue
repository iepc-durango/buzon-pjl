<template>


<section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
    <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nuevo Correo</h1>
    
        

        <form @submit.prevent="submitForm">
            <!-- Select para Tipo -->
            <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                <label for="tipo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                <select v-model="form.tipo_id" id="tipo_id"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" required>
                    <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
                        {{ tipo.tipo }}
                    </option>
                </select>
            </div>

            <!-- Select para Destinatarios -->
            <div class="form-group">
                <label for="destinatario_id">Destinatario</label>
                <select v-model="form.destinatario_id" id="destinatario_id" class="border form-control" required>
                    <option v-for="destinatario in destinatarios" :key="destinatario.id" :value="destinatario.id">
                        {{ destinatario.nombre }}
                    </option>
                </select>
            </div>

            <!-- Título -->
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" v-model="form.titulo" id="titulo" class="form-control" required />
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea v-model="form.descripcion" id="descripcion" class="form-control" required></textarea>
            </div>

            <!-- Fecha -->
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" v-model="form.fecha" id="fecha" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary">Crear Notificación</button>
        </form>
    
    </section>
</template>

<script setup>
// Importamos `useForm` de Inertia
import { useForm } from '@inertiajs/inertia-vue3';

// Usamos `defineProps` para recibir las props que vienen desde Laravel/Inertia
const props = defineProps({
    tipos: Array,
    destinatarios: Array,
});

// Inicializamos el formulario con `useForm`
const form = useForm({
    tipo_id: '',  // Inicializamos con valores vacíos
    destinatario_id: '',
    titulo: '',
    descripcion: '',
    fecha: '',
});

// Función para enviar el formulario
const submitForm = () => {
    form.post(route('notificaciones.store'), {
        onSuccess: () => {
            console.log('Notificación creada y correo enviado');
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};
</script>

<style scoped>
/* Estilos personalizados para tu formulario */
</style>
