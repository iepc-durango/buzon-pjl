<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Pagination.vue";

// Propiedades
const props = defineProps({
  destinatarios: {
    type: Object,
    required: true,
  },
});

// Variables reactivas
let selectedDestinatarios = ref([]);  // Eliminamos la persistencia de localStorage
let search = ref(usePage().props.search || ""); // Valor de búsqueda
let pageNumbers = ref(usePage().props.currentPage || 1); // Página actual

// Función para obtener el destinatario completo por su ID
const getDestinatarioById = (id) => {
  // Buscar destinatario en los datos de la página actual
  const destinatario = props.destinatarios.data.find(dest => dest.id === id);
  if (destinatario) {
    return destinatario;
  }

  // Si no se encuentra en los datos actuales, tratar de obtener de localStorage
  const allDestinatarios = JSON.parse(localStorage.getItem('allDestinatarios')) || [];
  return allDestinatarios.find(dest => dest.id === id) || { correo: 'No disponible' };
};

// Computed para actualizar la URL con los parámetros de búsqueda y la página
let destinatarioUrl = computed(() => {
  let url = new URL(route("destinatarios.index"));

  // Solo agregar el parámetro de búsqueda si existe
  if (search.value) {
    url.searchParams.append("search", search.value);
  }

  // Incluir el parámetro de la página actual
  url.searchParams.append("page", pageNumbers.value);

  return url.toString();
});

// Función para actualizar el número de página
const updatePageNumbers = (link) => {
  pageNumbers.value = link.url.split("=")[1];
};

// Actualiza los destinatarios seleccionados
const updateSelectedDestinatarios = (id) => {
  // Si ya está seleccionado, lo eliminamos
  if (selectedDestinatarios.value.includes(id)) {
    selectedDestinatarios.value = selectedDestinatarios.value.filter(item => item !== id);
  } else {
    // Si no está seleccionado, lo agregamos
    selectedDestinatarios.value.push(id);
  }
};

// Sincronizar `selectedDestinatarios` al montar el componente
onMounted(() => {
  // Limpiar la selección de destinatarios al montar la página
  selectedDestinatarios.value = []; // Esto asegura que los checkboxes no permanezcan seleccionados

  // Si se desea almacenar la lista completa de destinatarios en localStorage, se puede hacerlo aquí.
  const allDestinatarios = [...props.destinatarios.data, ...JSON.parse(localStorage.getItem('allDestinatarios') || '[]')];
  localStorage.setItem('allDestinatarios', JSON.stringify(allDestinatarios));
});

// Realizar la solicitud cada vez que la URL cambie (cuando se haga una búsqueda o se cambie de página)
watch(destinatarioUrl, (updatedDestinatarioUrl) => {
  router.visit(updatedDestinatarioUrl, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
  });
});

// Realizar la búsqueda cuando cambia el valor de búsqueda
watch(search, (newSearch) => {
  pageNumbers.value = 1; // Reseteamos a la página 1 al buscar
  router.visit(destinatarioUrl.value, { preserveState: true });
});
</script>

<template>
  <AppLayout title="ListaPersonalizada">
    <Head title="Destinatarios" />
  
    <div class="grid grid-cols-2 gap-4 py-20">
      <!-- Sección de lista de destinatarios -->
      <div class="max-w-full md:w-auto bg-white rounded-lg">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <div class="bg-gray-100 py-10">
            <div class="mx-auto max-w-7xl">
              <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                  <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Destinatarios</h1>
                    <p class="mt-2 text-sm text-gray-700">
                      Selecciona los correos a donde se enviará tu correo.
                    </p>
                  </div>
                </div>
  
                <div class="flex flex-col justify-between sm:flex-row mt-6">
                  <div class="relative text-sm text-gray-800 col-span-3">
                    <input
                      v-model="search"
                      type="text"
                      autocomplete="off"
                      placeholder="Search Destinatarios..."
                      id="search"
                      class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                  </div>
                </div>
  
                <div class="mt-8 flex flex-col">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Email</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr v-for="destinatario in destinatarios.data || []" :key="destinatario.id">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                          <input
                            :checked="selectedDestinatarios.includes(destinatario.id)"
                            @change="updateSelectedDestinatarios(destinatario.id)"
                            type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                          />
                        </td>
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ destinatario.nombre }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">
                          <!-- Mostrar el correo del destinatario si está seleccionado -->
                          {{ selectedDestinatarios.includes(destinatario.id) && destinatario.correo ? destinatario.correo : getDestinatarioById(destinatario.id)?.correo || 'No disponible' }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :data="destinatarios" :updatePageNumbers="updatePageNumbers" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Destinatarios seleccionados -->
      <div class="max-w-full md:w-auto bg-white rounded-lg">
        <h2 class="font-mono text-xl font-semibold">Destinatarios Seleccionados</h2>
        <div v-if="selectedDestinatarios.length > 0">
          <h3>Destinatarios seleccionados:</h3>
          <ul>
            <li v-for="id in selectedDestinatarios" :key="id">
              {{ getDestinatarioById(id)?.correo || 'No disponible' }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  
    <div class="flex justify-center">
      <button type="button" class="bg-[#545559] text-white px-5 py-2.5 rounded-lg">
        Enviar Correo
      </button>
    </div>
  </AppLayout>
</template>
