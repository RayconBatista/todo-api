<template>
    <div>
      <button @click="toggleModal" class="px-3 py-1 font-bold dark:text-white bg-blue-500 rounded hover:bg-blue-700">
        {{ title }}
      </button>
  
      <div v-if="isModalVisible" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                {{ title }}
              </h3>
              <button @click="hideModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <i class="fa-solid fa-xmark text-red-500"></i>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
              <slot />
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
              <button @click="acceptFunction" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Salvar
              </button>
              <button @click="hideModal" type="button" class="text-gray-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 bg-gray-500 dark:bg-red-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                Fechar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import { ref } from 'vue';

  export default {
    name: "Modal",
    props: {
      title: String,
      acceptFunction: Function,
    },
    emits: ['close-modal'],
    setup() {
        const isModalVisible = ref(false);

        const toggleModal = () => {
            isModalVisible.value = !isModalVisible.value
        }

        const hideModal = () => {
            isModalVisible.value = false;
        }

        return {
            isModalVisible,
            toggleModal,
            hideModal
        }
    }
  };
  </script>
  