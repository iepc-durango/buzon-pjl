<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const isLoading = ref(true);

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
    router.get('/login'); // Redirige con Inertia.js
  }, 4000);
});
</script>

<template>
    <Head title="Inicio" />

    <div class="bg-white text-black/50 dark:bg-white dark:text-white/50">

    <div class="flex lg:justify-center lg:col-start-2">

    <img
    class="p-20 md:h-1/2 md:w-3/6 "
    src="../../../public/img/logo.jpeg"
    >
</div>

<h1 class="text-center  text-[#3B3C40] font-sans text-5xl font-semibold">BUZON ELECTRONICO</h1>
<h2 class="text-center text-[#545559] p-8 text-3xl">PODER JUDICIAL</h2> 


<Transition name="fade">
   
   <div v-if="isLoading" class='loading-screen flex space-x-2 justify-end py-10 items- h-screen dark:invert'>
   <span class='sr-only'>Loading...</span>
    <div class='h-4 w-4 bg-[#545559] rounded-full animate-bounce [animation-delay:-0.3s]'></div>
  <div class='h-4 w-4 bg-[#545559] rounded-full animate-bounce [animation-delay:-0.15s]'></div>
  <div class='h-4 w-4 bg-[#545559] rounded-full animate-bounce'></div>
</div>
 </Transition>




        </div>


       

        
    
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
.loading-screen {
  @apply fixed top-60 left-0 w-full h-full flex justify-center items-center;
}
</style>