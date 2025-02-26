<template>

    <AppLayout title="Nueva Notificación">
        <Head title="Nuevo Correo"/>

        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
            <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nueva Notificacion</h1>

            <form @submit.prevent="generarPDF">

                <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Notificación</label>
                        <select v-model="form.tipo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                            <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id" class="border border-gray-50">
                                {{ tipo.tipo }}
                            </option>
                        </select>
                    </div>
                </div>


                <!-- Campos para Acuerdo -->
                <div v-if="selectedTipo?.tipo === 'Acuerdo'">

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="titulo">Título</label>
                            <textarea v-model="form.titulo" Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>

                        </div>
                    </div>


                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="acuerdo">No. acuerdo</label>
                            <input v-model="form.no_acuerdo" Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>

                        </div>


                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="sesion">Sesión</label>
                            <input v-model="form.sesion" Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-medium">Resumen</label>
                            <textarea v-model="form.descripcion" Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium">Fecha de Aprobación</label>
                            <input v-model="form.fecha_aprobacion" Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" type="date"/>
                        </div>
                    </div>

                </div>

                <!-- Campos para PES -->
                <div v-else-if="selectedTipo?.tipo === 'PES'">
                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="no_expediente">Número de Expediente</label>
                            <input id="no_expediente" v-model="form.no_expediente" Required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Número de Expediente"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">

                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="denunciante">Denunciante</label>
                            <input id="denunciante" v-model="form.denunciante" Required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Denunciante"/>
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="denunciado">Denunciado</label>
                            <input id="denunciado" v-model="form.denunciado" Required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Denunciado"/>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="municipio">Municipio</label>
                            <select id="municipio" v-model="form.municipio"
                                    Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray focus:border-gray- block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                <option v-for="municipio in municipios" :key="municipio" :value="municipio">
                                    {{ municipio }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="descripcion_fundamento">Descripción del Fundamento</label>
                            <textarea id="descripcion_fundamento" v-model="form.descripcion_fundamento"
                                      Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">a>

                    </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="descripcion_docu" class="block text-gray-600 text-sm font-medium">Descripción del Documento</label>
                        <textarea v-model="form.descripcion_docu" id="descripcion_docu"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"Required></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="frag_doc">Fragmento del Documento</label>
                            <textarea id="frag_doc" v-model="form.frag_doc"
                                      Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium" for="descripcion_notificado">Descripción del Notificado</label>
                            <textarea id="descripcion_notificado" v-model="form.descripcion_notificado"
                                      Required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"></textarea>
                        </div>
                    </div>

                </div>


                <!--Lineas de codigo para adjuntar los archivos-->
                <div class="flex items-center justify-center w-full py-8">
                    <!--<div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">-->
                    <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg aria-hidden="true" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click para </span> Adjuntar archivos adicionales</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input multiple type="file" @change="handleFileUpload"/>
                    </label>

                </div>


                <div class="flex justify-center mt-8">
                    <button class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-12 py-3 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800" type="submit">
                        Siguiente
                    </button>
                </div>


            </form>

        </section>

        <!-- Modal de Selección de Lista -->
        <div v-if="modalVisible" class="modal">
            <div class="modal-content space-y-8">
                <h3>Selecciona una opción</h3>
                <p>¿Deseas guardar esta notificación en la lista global o en una lista personalizada?</p>
                <div class="flex flex-col justify-center items-center space-y-2">
                    <button class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-10 py-2 text-center mb-2 block dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800" type="button" @click="seleccionarLista('global')">
                        Lista Global
                    </button>
                    <button class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center mb-2 block dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800" type="button" @click="seleccionarLista('personalizada')">
                        Lista Personalizada
                    </button>
                </div>

                <button @click="modalVisible = false">Cerrar</button>
            </div>
        </div>


        <!-- Modal para lista personalizada: selección de destinatarios -->
        <div v-if="personalizadaModalVisible" class="modal">
            <div class="modal-content space-y-10">
                <h3>Selecciona destinatarios</h3>
                <!-- Contenedor con scroll: ajusta max-h-64 (16rem) o el valor que prefieras -->
                <div class="max-h-64 overflow-y-auto border p-2">
                    <div v-for="dest in destinatarios" :key="dest.id" class="py-1">
                        <label class="flex items-center space-x-2">
                            <input v-model="selectedDestinatarios" :value="dest.id" type="checkbox">
                            <span>{{ dest.nombre }} ({{ dest.correo }})</span>
                        </label>
                    </div>
                </div>
                <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800" type="button" @click="enviarCorreoPersonalizado">
                    Enviar a seleccionados
                </button>
                <button type="button" @click="personalizadaModalVisible = false">Cancelar</button>
            </div>
        </div>


        <!-- Modal de Confirmación de Envío Global -->
        <div v-if="confirmModalVisible" class="modal">
            <div class="modal-content space-y-8">
                <h3>Confirmar Envío</h3>
                <p>¿Estás seguro de que deseas enviar este correo a todos los usuarios existentes?</p>
                <button class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800" type="button" @click="enviarCorreoGlobal">Sí, enviar</button>
                <button @click="confirmModalVisible = false">Cancelar</button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {ref, computed, watch} from 'vue';
import {useForm} from '@inertiajs/vue3';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

// Configura Axios para enviar las cookies de sesión
axios.defaults.withCredentials = true;

const props = defineProps({
    tipos: Array,
    municipios: Array,
    destinatarios: Array
});

const form = useForm({
    tipo_id: '',
    titulo: '',
    no_acuerdo: '',
    sesion: '',
    descripcion: '',
    fecha_aprobacion: '',
    no_expediente: '',
    denunciante: '',
    denunciado: '',
    municipio: '',
    descripcion_fundamento: '',
    descripcion_docu: '',
    frag_doc: '',
    descripcion_notificado: ''
});

//Lineas de codigo para adjuntar archivos

const attachments = ref([]);

const handleFileUpload = (event) => {
    console.log("Archivos seleccionados:", event.target.files);
    attachments.value = Array.from(event.target.files);
};


const selectedTipo = computed(() => props.tipos.find(t => t.id === form.tipo_id));
const modalVisible = ref(false);
const confirmModalVisible = ref(false);
const personalizadaModalVisible = ref(false);
const selectedDestinatarios = ref([]);

const generarPDF = async () => {
    try {
        //Lineas para adjuntar archivos

        const formData = new FormData();
        Object.entries(form.data()).forEach(([key, value]) => {
            formData.append(key, value);
        });

        // Envía también el tipo en texto (usando tu computed selectedTipo)
        formData.append('tipo', selectedTipo.value.tipo);


        // Agrega cada archivo seleccionado
        attachments.value.forEach((file, index) => {
            formData.append(`attachments[]`, file);
        });


        // await axios.post('/notificaciones/generar-pdf-temporal', {

        //     ...form.data(),
        //     tipo: selectedTipo.value.tipo
        // });

        await axios.post('/notificaciones/generar-pdf-temporal', formData, {
            headers: {"Content-Type": "multipart/form-data"}
        });

        modalVisible.value = true;
    } catch (error) {
        console.error("Error generando PDF", error);
    }
};

const seleccionarLista = (tipo) => {
    if (tipo === 'global') {
        confirmModalVisible.value = true;
    } else if (tipo === 'personalizada') {
        personalizadaModalVisible.value = true;
    }
};

const enviarCorreoGlobal = async () => {
    try {
        await axios.post('/notificaciones/enviar-correo-global');
        confirmModalVisible.value = false;
        modalVisible.value = false;
        alert("Correo enviado globalmente a todos los usuarios.");
    } catch (error) {
        console.error("Error enviando el correo global", error);
    }
};

const enviarCorreoPersonalizado = async () => {
    if (selectedDestinatarios.value.length === 0) {
        alert("Debes seleccionar al menos un destinatario.");
        return;
    }
    try {
        const response = await axios.post('/notificaciones/enviar-correo-personalizado', {
            destinatarios: selectedDestinatarios.value
        });
        console.log("Respuesta del servidor:", response.data);
        personalizadaModalVisible.value = false;
        modalVisible.value = false;
        alert("Correo enviado a los destinatarios seleccionados.");
    } catch (error) {
        console.error("Error enviando el correo personalizado", error);
    }
};
</script>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}
</style>
