<template>
    <div>
      <h1>Buscar Destinatario</h1>
      <input v-model="query" @input="handleSearch" placeholder="Buscar..." class="border p-2" />
      <ul v-if="results.length > 0">
        <li v-for="result in results" :key="result.id">{{ result.name }}</li>
      </ul>
      <p v-else>No se encontraron resultados</p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      results: Array
    },
    data() {
      return {
        query: ''
      }
    },
    methods: {
      handleSearch() {
        this.$inertia.get('/search', { query: this.query }, { preserveState: true });
      }
    }
  }
  </script>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  