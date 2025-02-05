<template>
    <div>
      <!-- El div que actuará como el contenedor del editor -->
      <div ref="editor" class="editor"></div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  import Quill from 'quill';
  
  // Crear una referencia para el contenedor del editor
  const editor = ref(null);
  
  // Usamos onMounted para inicializar Quill una vez que el componente esté montado
  onMounted(() => {
    // Inicializar Quill con el contenedor del editor
    new Quill(editor.value, {
      theme: 'snow', // Puedes elegir entre 'snow' y 'bubble'
      modules: {
        toolbar: [
          [{ header: '1' }, { header: '2' }, { font: [] }],
          [{ list: 'ordered' }, { list: 'bullet' }],
          ['bold', 'italic', 'underline'],
          ['link'],
          [{ align: [] }],
          ['image'],
        ],
      },
    });
  });
  </script>
  
  <style scoped>
  .editor {
    height: 200px; /* Define el tamaño del editor */
  }
  </style>