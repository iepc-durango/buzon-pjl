<template>
    <div class="container">
      <h1>Generar Documento Word</h1>
      <form @submit.prevent="generateWord">
        <label>Nombre:</label>
        <input v-model="formData.nombre" type="text" required />
  
        <label>Dirección:</label>
        <input v-model="formData.direccion" type="text" required />
  
        <label>Fecha:</label>
        <input v-model="formData.fecha" type="date" required />
  
        <button type="submit">Generar y Descargar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import axios from "axios";
  
  const formData = ref({
    nombre: "",
    direccion: "",
    fecha: "",
  });
  
  const generateWord = async () => {
    try {
      const response = await axios.post("/generate-word", formData.value, {
        responseType: "blob", // Necesario para manejar archivos
      });
  
      // Crear un enlace para descargar el archivo
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "documento_generado.docx");
      document.body.appendChild(link);
      link.click();
      link.remove();
    } catch (error) {
      console.error("Error al generar el documento:", error);
    }
  };
  </script>
  
  <style>
  .container {
    max-width: 400px;
    margin: auto;
    text-align: center;
  }
  input {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 5px;
  }
  button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
  </style>
  ``
  