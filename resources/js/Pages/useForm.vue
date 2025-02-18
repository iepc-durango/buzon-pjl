<template>
    <div class="max-w-lg mx-auto p-8 bg-white rounded-lg shadow-lg">
      <form @submit.prevent="enviar">
        <!-- Selector de archivo -->
        <div class="mb-4">
          <label for="avatar" class="block text-lg font-semibold text-gray-700">Selecciona un archivo</label>
          <input
            type="file"
            id="avatar"
            @change="seleccionarArchivo"
            accept="image/*, application/pdf"
            class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500"
          />
        </div>
  
        <!-- Vista previa de imagen -->
        <div v-if="esImagen" class="mb-4 flex justify-center">
          <img :src="vistaPrevia" alt="Vista previa" class="max-w-full h-40 object-cover rounded-md border border-gray-300" />
        </div>
  
        <!-- Vista previa de PDF -->
        <div v-if="esPDF" class="mb-4 flex justify-center">
          <embed :src="vistaPrevia" type="application/pdf" class="w-full h-52 border border-gray-300 rounded-md" />
        </div>
  
        <!-- Barra de progreso -->
        <div class="mb-4" v-if="formulario.progreso">
          <label for="progress" class="block text-lg font-semibold text-gray-500">Progreso de carga</label>
          <progress
            id="progress"
            :value="formulario.progreso.porcentaje"
            max="100"
            class="mt-2 w-full h-2 bg-gray-200 rounded-full"
          >
            {{ formulario.progreso.porcentaje }}%
          </progress>
          <div class="text-center text-gray-700 mt-1">{{ formulario.progreso.porcentaje }}%</div>
        </div>
  
        <!-- Botón de enviar -->
        <button
          type="submit"
          class="w-full mt-4 py-3 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-gray-600"
        >
          Subir archivo
        </button>
  
        <!-- Mensaje de éxito -->
        <div v-if="mensajeExito" class="mt-4 text-center text-green-600 font-semibold">
          Archivo subido correctamente.
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3'
  import { ref } from 'vue'
  
  const formulario = useForm({
    avatar: null,
    progreso: null,  
  })
  
  const mensajeExito = ref(false)  
  const vistaPrevia = ref(null)  
  const esImagen = ref(false)  
  const esPDF = ref(false)  
  
  const seleccionarArchivo = (event) => {
    const archivo = event.target.files[0]  
  
    if (archivo) {
      formulario.avatar = archivo  
      const tipoArchivo = archivo.type  
  
      if (tipoArchivo.includes('image')) {
        esImagen.value = true
        esPDF.value = false
        vistaPrevia.value = URL.createObjectURL(archivo)
      } else if (tipoArchivo === 'application/pdf') {
        esImagen.value = false
        esPDF.value = true
        vistaPrevia.value = URL.createObjectURL(archivo)
      } else {
        esImagen.value = false
        esPDF.value = false
        vistaPrevia.value = null
        alert('Formato no compatible. Solo imágenes y PDFs están permitidos.')
      }
    }
  }
  
  const enviar = () => {
    formulario.post('/upload', {
      onProgress: (event) => {
        if (event.lengthComputable) {
          formulario.progreso = {
            porcentaje: Math.round((event.loaded / event.total) * 100)
          }
        }
      },
      onSuccess: () => {
        mensajeExito.value = true  
        formulario.reset()  
        vistaPrevia.value = null  
        esImagen.value = false  
        esPDF.value = false  
      },
      onError: () => {
        alert('Hubo un error al subir el archivo.')
      }
    })
  }
  </script>
  