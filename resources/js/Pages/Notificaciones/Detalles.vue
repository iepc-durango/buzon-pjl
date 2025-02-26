<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

import { defineProps, ref } from 'vue';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

// Usamos defineProps para obtener las propiedades que son pasadas al componente
const props = defineProps({
  detalles: Array
});

// Función para generar el PDF
const exportarPDF = async () => {
  const tabla = document.getElementById('tabla-detalles');
  const pdf = new jsPDF('p', 'mm', 'a4');

  // Capturamos la tabla en una imagen usando html2canvas
  const canvas = await html2canvas(tabla);
  const imgData = canvas.toDataURL('image/png');

  const imgWidth = 190; // Ancho de la imagen en el PDF
  const pageHeight = pdf.internal.pageSize.height; 
  const imgHeight = (canvas.height * imgWidth) / canvas.width;

  let heightLeft = imgHeight;
  let position = 10;

  pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
  heightLeft -= pageHeight;

  while (heightLeft >= 0) {
    position = heightLeft - imgHeight;
    pdf.addPage();
    pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
    heightLeft -= pageHeight;
  }

  pdf.save('tabla-detalles.pdf');
};
</script>

<template>
    <AppLayout title="Detalles">
        <div class="py-10 flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Detalles</h2>
            <button 
                @click="exportarPDF"
                class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Imprimir detalles
            </button>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabla de detalles -->
            <div class="flex justify-center">
                <div class="relative overflow-x-auto max-w-7xl w-full shadow-md sm:rounded-lg" id="tabla-detalles">
                    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-ls text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Notificación</th>
                                <th scope="col" class="px-6 py-3">Destinatario</th>
                                <th scope="col" class="px-6 py-3">Fecha de Envío</th>
                                <th scope="col" class="px-6 py-3">Estado de Notificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="detalle in props.detalles" :key="detalle.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ detalle.id_notificacion }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ detalle.destinatario.nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ new Date(detalle.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' }) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ detalle.status_abierto }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
