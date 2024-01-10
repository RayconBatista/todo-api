<template>
    <div class="container">
        <Header title="Convidados" />
        <div
            class="w-full p-2 text-center bg-white dark:bg-gray-800 rounded-lg shadow sm:p-8  dark:border-gray-700 max-h-full">
            <div class="flex items-end mb-4">
                <Modal ref="modalInviteRef" class="items-end ml-auto" title="Convidar" :acceptFunction="sendInvite">
                    <!-- Conteúdo do modal aqui -->
                    <input type="text" v-model="form.email" placeholder="Inserir email"
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4">
                </Modal>
            </div>
            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Email</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Status</th>
                            <!-- <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="user in invites" :key="user.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                user.id }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                user.email }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ user.registered_at ? "Registrado" : "Pendente" }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import { useStore } from 'vuex';
import { computed, onMounted, ref } from 'vue';
import Header from "@/ui/components/Header.vue";
import Modal from '@/ui/components/Modal.vue';
import { useNotification } from "@kyvg/vue3-notification";
import UserService from '@/infra/services/users.service.js';
export default {
    name: "Invites",
    components: {
        Header,
        Modal
    },
    setup() {
        const store = useStore();
        const invites = computed(() => store.state.invites.invites);
        const form = ref({ email: '' });
        const { notify } = useNotification();
        const modalInviteRef = ref(null);

        onMounted(() => {
            store.dispatch('getInvites');
        });

        const sendInvite = () => {
            UserService.sendInvite(form.value.email).then(() => {
                notify({
                    title: "Deu certo",
                    text: "Usuário convidado com sucesso",
                    type: "success",
                });
            }).finally(() => {
                form.value = '';
                modalInviteRef.value.hideModal();
                store.dispatch('getInvites');
            })
        }

        return {
            invites,
            form,
            sendInvite,
            modalInviteRef
        }
    }
}
</script>