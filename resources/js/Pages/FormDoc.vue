<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import { onMounted,ref } from 'vue'
import { Modal } from 'flowbite'
import Quill from 'quill';

onMounted(() => {
    const $buttonElement = document.querySelector('#button');
    const $linkElement = document.querySelector('#link');
    const $modalElement = document.querySelector('#modal');
    const $modal2Element = document.querySelector('#modal2');
    const $closeButton = document.querySelector('#closeButton');
    const $closeButton2 = document.querySelector('#closeButton2');


    const modalOptions = {
        backdropClasses: ''
    }

    if ($modalElement) {
        const modal = new Modal($modalElement, modalOptions);
        $buttonElement.addEventListener('click', () => modal.toggle());
        $closeButton.addEventListener('click', () => modal.hide());
        $linkElement.addEventListener('click',() =>modal.hide());
        
        // programmatically show
        // modal.show();
    }

    if ($linkElement) {
        const modal2 = new Modal($modal2Element, modalOptions);
        $linkElement.addEventListener('click', () => modal2.toggle());
        $closeButton2.addEventListener('click', () => modal2.hide());

        
        // programmatically show
        // modal.show();
    }

    


})


const content = ref(''); // Variable para almacenar el contenido
  
  const editor = ref(null);
  
  // Crear una instancia de Quill y sincronizar con el valor de content
  onMounted(() => {
    const quill = new Quill(editor.value, {
      theme: 'snow',
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
  
    // Sincroniza el contenido del editor con la variable content
    quill.on('text-change', () => {
      content.value = quill.root.innerHTML;
    });
  });

</script>

 <style scoped>
  .editor {
    height: 300px;
  }
  </style>



<template>


<AppLayout title="Dashboard">
    <Head title="Welcome" />

    
   


        <section class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-8">
            <h1 class="text-xl font-bold text-black capitalize dark:text-white">Nuevo Correo</h1>

            <form>
        <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-1">
            <div>
                <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titulo</label>
                <input type="text" id="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" required />
            </div>

            </div>

            <div class="grid grid-cols-1 gap-6 mt-5 sm:grid-cols-2">
                <div>
                    <label for="sesion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sesion</label>
                    <input type="text" id="sesion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" required />
                </div>
            

            <div>
                <label for="acuerdo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Acuerdo</label>
                <input type="text" id="acuerdo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" required />
            </div>

            <div>
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
  <select id="countries" class="">
    <option selected>Choose a country</option>
    <option value="US">United States</option>
    <option value="CA">Canada</option>
    <option value="FR">France</option>
    <option value="DE">Germany</option>
  </select>
            </div>

            <div>
                <label for="acuerdo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especificar</label>
                <input type="text" id="acuerdo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" required />
            </div>


            <div  ref="editor" class="editor">
               
                <label class="text-black dark:text-gray-200" for="passwordConfirmation">Descripción</label>
                <textarea v-model="content" name="content" id="textarea" type="textarea" class="block mt-4 w-full h-20 px-4 py-2 mt-2 text-gray-700 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 "></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-black">
                Archivos
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-[#D9D9D9]">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" stroke-linecap="round"  fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-[#D9D9D9] rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span class="">Upload a file</span>
                      <input id="file-upload" name="file-upload" type="file" class="sr-only">
                    </label>
                    <p class="pl-1 text-black">or drag and drop</p>
                  </div>
                  <p class="text-xs text-black">
                    PNG, JPG, GIF up to 10MB
                  </p>
                </div>
              </div>
            </div>

          
        </div>
        
        <div class="flex justify-end mt-6">
            <button  id="button" class="block w-full md:w-auto text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
    Enviar
    </button>

        </div>


        <Editor v-model="value" editorStyle="height: 320px" />
        
            </form>

        </section>

        
        

    <!-- Modal de Listas -->
<div id="modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Lista de Envio
                </h3>
                <button id="closeButton" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Selecciona la lista de tu preferencia para enviar tu correo</p>
                <ul class="my-4 space-y-3">
                    
                    <li>
                        <a id="link" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
</svg>

                            <span class="flex-1 ms-3 whitespace-nowrap">Lista Global</span>
                        </a>
                    </li>
                    
                    
                    <li>
                        <Link href="/listapersonalizada" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
</svg>

                            <span class="flex-1 ms-3 whitespace-nowrap">Lista personalizada</span>
                    </Link>
                    </li>
                </ul>
                <div>
                    <a href="#" class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        Una vez seleccionada la lista ya no podrás editar tu correo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Lista Global -->
<div id="modal2" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button id="closeButton2" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Seguro que deseas enviar el correo a todos los usuarios existentes?</h3>
                <button data-modal-hide="popup-modal" type="button" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Si, enviar
                </button>
                <button  type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
            </div>
        </div>
    </div>
</div>


       
        </AppLayout>

     
    
</template>