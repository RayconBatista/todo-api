<template>
    <div class="container">
        <Header title="Usuários" />
        <div
            class="w-full p-2 text-center bg-white dark:bg-gray-800 rounded-lg shadow sm:p-8  dark:border-gray-700 max-h-full">
  
            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Email</th>
                            <!-- <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="user in users" :key="user.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                user.id }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                user.first_name }} {{ user.last_name }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                user.email }}</td>
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
import { useNotification } from "@kyvg/vue3-notification";
import Header from '../../components/Header.vue';
import Modal from '../../components/Modal.vue';
// import UserService from '@/infra/services/users.service.js';
export default {
    components: {
        Header,
        // Modal
    },
    setup() {
        const store = useStore();
        const users = computed(() => store.state.users.users);
        const { notify } = useNotification();
        // const form = ref({ email: '' });
        // const modalInviteRef = ref(null);

        onMounted(() => {
            store.dispatch('getUsers');
        });

        // const sendInvite = () => {
        //     UserService.sendInvite(form.value.email).then(() => {
        //         notify({
        //             title: "Deu certo",
        //             text: "Usuário convidado com sucesso",
        //             type: "success",
        //         });
        //     }).finally(() => {
        //         modalInviteRef.value.hideModal()
        //     })
        // }

        return {
            users,
            // form,
            // sendInvite,
            // modalInviteRef
        }
    }
}
</script>