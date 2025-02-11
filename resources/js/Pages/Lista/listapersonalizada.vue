<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3';

const checkedNames = ref([])


defineProps({
    destinatarios: {
        type: Object,
        required: true,
    },
});


console.log(usePage().props.destinatarios);

</script>

<template>


  
  <AppLayout title="ListaPersonalizada">
    <Head title="Welcome" />
    
    <!-- component -->
<!-- This is an example component -->
<div class="grid grid-cols-2 gap-4 py-20">
<div class="max-w-full md:w-auto  bg-white rounded-lg">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
  
    <div class="bg-gray-100 py-10">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">
                            Destinatarios
                        </h1>
                        <p class="mt-2 text-sm text-gray-700">
                            Seleciona los correos a donde se enviara tu correo
                        </p>
                    </div>

                </div>

                <div class="flex flex-col justify-between sm:flex-row mt-6">
                    <div class="relative text-sm text-gray-800 col-span-3">
                        <div
                            class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500"
                        >
                            <MagnifyingGlass />
                        </div>

                        <input
                            type="text"
                            autocomplete="off"
                            placeholder="Search Destinatarios..."
                            id="search"
                            class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-center md:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-300"
                                >
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                ID
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                Nombre
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                Email
                                            </th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        <tr v-for="destinatarios in destinatarios.data" :key="destinatarios.id" >
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                              {{ destinatarios.id }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ destinatarios.nombre }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                            >
                                               {{ destinatarios.correo }}
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>

                                <Pagination  :data="destinatarios.data"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  
</div>


<div class="max-w-full md:w-auto bg-white rounded-lg">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
  
<h2 class="font-mono text-xl font-semibold">Destinatarios Seleccionados</h2>


<div>{{ checkedNames.join(', ') }}</div>
  </div>
</div>

</div>


<div class="flex justify-center">
<button type="button" class="text-white  bg-[#545559] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 me-2 mb-2">
  
  <svg class="h-8 w-8 text-zinc-400 px-1"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="3" y="5" width="18" height="14" rx="2" />  <polyline points="3 7 12 13 21 7" /></svg>

Enviar Correo
</button>

</div>





    

      



   

    


</AppLayout>
    


        
    
</template>