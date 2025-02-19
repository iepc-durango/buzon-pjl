<template>
    <div>
        <h1>Crear Notificación</h1>

        <form @submit.prevent="submitForm">
            <!-- Select para Tipo -->
            <div class="form-group">
                <label for="tipo_id">Tipo</label>
                <select v-model="form.tipo_id" id="tipo_id" class="form-control" required>
                    <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
                        {{ tipo.tipo }}
                    </option>
                </select>
            </div>

            <!-- Select para Destinatarios -->
            <div class="form-group">
                <label for="destinatario_id">Destinatario</label>
                <select v-model="form.destinatario_id" id="destinatario_id" class="form-control" required>
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
    </div>
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
