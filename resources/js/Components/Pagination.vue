<script setup>
import { router } from '@inertiajs/vue3'

// Definimos las propiedades que recibe el componente
defineProps({
    data: {
        type: Object,
        required: true,
    }
});

// Función para cambiar la página y mantener los parámetros de búsqueda y checkbox
const updatePageNumbers = (link) => {
    if (!link.url) return;

    // Obtener la URL del enlace de paginación
    const url = new URL(link.url);

    // Obtener los parámetros de la URL actual (búsqueda y checkboxes seleccionados)
    const searchParam = new URLSearchParams(window.location.search).get('search');
    const checkboxParam = new URLSearchParams(window.location.search).get('checkbox');

    // Añadir los parámetros de búsqueda y checkbox si existen
    if (searchParam) {
        url.searchParams.set('search', searchParam);
    }

    if (checkboxParam) {
        url.searchParams.set('checkbox', checkboxParam);
    }

    // Redirigir a la nueva URL con los parámetros actuales
    router.visit(url.toString(), {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
<div class="max-w-7xl mx-auto py-6">
    <div class="max-w-none mx-auto">
        <div class="bg-white overflow-hidden shadow sm:rounded-lg">
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden" />
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium" v-if="data.meta && data.meta.from">
                                {{ data.meta.from }}
                            </span>
                            to
                            <span class="font-medium" v-if="data.meta && data.meta.to">
                                {{ data.meta.to }}
                            </span>
                            of
                            <span class="font-medium" v-if="data.meta && data.meta.total">
                                {{ data.meta.total }}
                            </span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <!-- Botón de paginación -->
                            <button
                                v-for="(link, index) in data.meta.links"
                                :key="index"
                                @click.prevent="updatePageNumbers(link)"
                                :disabled="link.active || !link.url"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                :class="{
                                    'z-10 bg-[#A6A6A6] text-white': link.active,
                                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active,
                                }"
                            >
                                <span v-html="link.label"></span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
