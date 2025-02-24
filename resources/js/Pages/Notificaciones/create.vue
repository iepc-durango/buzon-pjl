<template>

    <AppLayout>
        <Head title="Nuevo Correo"/>

        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
            <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nueva Notificacion</h1>

            <form @submit.prevent="generarPDF">

                <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Notificación</label>
                        <select v-model="form.tipo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                            <option class="border border-gray-50" v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
                                {{ tipo.tipo }}
                            </option>
                        </select>
                    </div>
                </div>


                <!-- Campos para Acuerdo -->
                <div v-if="selectedTipo?.tipo === 'Acuerdo'">

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                            <textarea v-model="form.titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>

                        </div>
                    </div>


                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">
                        <div>
                            <label for="acuerdo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. acuerdo</label>
                            <input v-model="form.no_acuerdo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>

                        </div>


                        <div>
                            <label for="sesion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sesión</label>
                            <input v-model="form.sesion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-medium">Resumen</label>
                            <textarea v-model="form.descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium">Fecha de Aprobación</label>
                            <input v-model="form.fecha_aprobacion" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>
                        </div>
                    </div>

                </div>

                <!-- Campos para PES -->
                <div v-else-if="selectedTipo?.tipo === 'PES'">
                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="no_expediente" class="block text-gray-600 text-sm font-medium">Número de Expediente</label>
                        <input v-model="form.no_expediente" id="no_expediente" placeholder="Número de Expediente"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>
                    </div>
                    </div>

                    <div  class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">
                        
                        <div>
                        <label for="denunciante"class="block text-gray-600 text-sm font-medium">Denunciante</label>
                        <input v-model="form.denunciante" id="denunciante" placeholder="Denunciante"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" />
                    </div>

                    <div>
                        <label for="denunciado" class="block text-gray-600 text-sm font-medium">Denunciado</label>
                        <input v-model="form.denunciado" id="denunciado" placeholder="Denunciado"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"/>
                    </div>

                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="municipio" class="block text-gray-600 text-sm font-medium">Municipio</label>
                        <select v-model="form.municipio" id="municipio"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray focus:border-gray- block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                            <option v-for="municipio in municipios" :key="municipio" :value="municipio">
                                {{ municipio }}
                            </option>
                        </select>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="descripcion_fundamento" class="block text-gray-600 text-sm font-medium">Descripción del Fundamento</label>
                        <textarea v-model="form.descripcion_fundamento" id="descripcion_fundamento" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" rows="4"></textarea>
                        
                    </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="descripcion_docu" class="block text-gray-600 text-sm font-medium">Descripción del Documento</label>
                        <textarea v-model="form.descripcion_docu" id="descripcion_docu" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" rows="4"></textarea>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="frag_doc" class="block text-gray-600 text-sm font-medium">Fragmento del Documento</label>
                        <textarea v-model="form.frag_doc" id="frag_doc" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" rows="4"></textarea>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
                        <div>
                        <label for="descripcion_notificado" class="block text-gray-600 text-sm font-medium">Descripción del Notificado</label>
                        <textarea v-model="form.descripcion_notificado" id="descripcion_notificado" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" rows="4"></textarea>
                    </div>
                    </div>

                    </div>


                <div class="flex justify-center mt-8">
                    <button type="submit" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-12 py-3 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                        Siguiente
                    </button>
                </div>
            </form>

        </section>

        <!-- Modal de Selección de Lista -->
        <div v-if="modalVisible" class="modal">
            <div class="modal-content">
                <h3>Selecciona una opción</h3>
                <p>¿Deseas guardar esta notificación en la lista global o en una lista personalizada?</p>
                <div class="flex flex-col justify-center items-center space-y-2">
                    <button @click="seleccionarLista('global')" type="button" class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-10 py-2 text-center mb-2 block dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800">
                        Lista Global
                    </button>
                    <button @click="seleccionarLista('personalizada')" type="button" class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center mb-2 block dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800">
                        Lista Personalizada
                    </button>
                </div>

                <button @click="modalVisible = false">Cerrar</button>
            </div>
        </div>


        <!-- Modal para lista personalizada: selección de destinatarios -->
        <div v-if="personalizadaModalVisible" class="modal">
            <div class="modal-content">
                <h3>Selecciona destinatarios</h3>
                <div v-for="dest in destinatarios" :key="dest.id">
                    <label>
                        <input type="checkbox" :value="dest.id" v-model="selectedDestinatarios">
                        {{ dest.nombre }} ({{ dest.correo }})
                    </label>
                </div>
                <button type="button" @click="enviarCorreoPersonalizado">Enviar a seleccionados</button>
                <button type="button" @click="personalizadaModalVisible = false">Cancelar</button>
            </div>
        </div>


        <!-- Modal de Confirmación de Envío Global -->
        <div v-if="confirmModalVisible" class="modal">
            <div class="modal-content">
                <h3>Confirmar Envío</h3>
                <p>¿Estás seguro de que deseas enviar este correo a todos los usuarios existentes?</p>
                <button @click="enviarCorreoGlobal" type="button" class="text-white bg-gray-500 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800">Sí, enviar</button>
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

const selectedTipo = computed(() => props.tipos.find(t => t.id === form.tipo_id));
const modalVisible = ref(false);
const confirmModalVisible = ref(false);
const personalizadaModalVisible = ref(false);
const selectedDestinatarios = ref([]);

const generarPDF = async () => {
    try {
        await axios.post('/notificaciones/generar-pdf-temporal', {
            ...form.data(),
            tipo: selectedTipo.value.tipo
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
