<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    
   
    <!-- Contenedor del botón fuera de la tabla -->
    <div class="flex justify-end py-3 px-4 mb-4">
        <Link
      href="/formdoc"
      class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none shadow-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-1.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
    >
      Agregar registro
    </Link>
        </div>
        
    
    

    <!-- Contenedor de la tabla -->
    <div class="relative overflow-x-auto shadow-0 py-3 sm:rounded-lg">
        <table class="w-full text-lm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
            <thead class="text-s text-gray-700 uppercase  bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-4">
                        Título/folio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        <a href="/detalles" class="font-medium text-gray-600 dark:text-blue-500 hover:underline">Detalles</a>
                    </td>
                </tr>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                        Microsoft Surface Pro
                    </th>
                    <td class="px-6 py-4">
                        White
                    </td>
                    <td class="px-6 py-4">
                        Laptop PC
                    </td>
                    <td class="px-6 py-4">
                        <a href="/detalles" class="font-medium text-gray-600 dark:text-blue-500 hover:underline">Detalles</a>
                    </td>
                </tr>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                        Magic Mouse 2
                    </th>
                    <td class="px-6 py-4">
                        Black
                    </td>
                    <td class="px-6 py-4">
                        Accessories
                    </td>
                    <td class="px-6 py-4">
                        <a href="/detalles" class="font-medium text-gray-600 dark:text-blue-500 hover:underline">Detalles</a>
                    </td>
                </tr>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                        Google Pixel Phone
                    </th>
                    <td class="px-6 py-4">
                        Gray
                    </td>
                    <td class="px-6 py-4">
                        Phone
                    </td>
                    <td class="px-6 py-4">
                        <a href="/detalles" class="font-medium text-gray-600 dark:text-blue-500 hover:underline">Detalles</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                        Apple Watch 5
                    </th>
                    <td class="px-6 py-4">
                        Red
                    </td>
                    <td class="px-6 py-4">
                        Wearables
                    </td>
                    <td class="px-6 py-4">
                        <a href="/detalles" class="font-medium text-gray-600 dark:text-blue-500 hover:underline">Detalles</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</template>