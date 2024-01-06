<template>
    <div>
        <!-- Botão que abre a modal -->
        <button @click="openModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Abrir Modal
        </button>

        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center">
            <div class="modal-overlay"></div>

            <div class="modal-container bg-white w-1/2 rounded-lg p-4">
                <!-- Conteúdo da modal -->
                <h2 class="text-xl font-bold mb-4">Título da Modal</h2>
                <p>Conteúdo da modal...</p>

                <!-- Botão que fecha a modal -->
                <button @click="closeModal" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-4">
                    Fechar Modal
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const isModalOpen = ref(false);

        const openModal = () => {
            isModalOpen.value = true;
        };

        const closeModal = () => {
            isModalOpen.value = false;
        };

        return {
            isModalOpen,
            openModal,
            closeModal,
        };
    },
};
</script>

<style>
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-container {
    max-height: 80vh;
    overflow-y: auto;
}
</style>
