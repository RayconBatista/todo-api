import UserService from '@/infra/services/users.service';
import { useNotification } from "@kyvg/vue3-notification";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const { notify } = useNotification();

export default ({
    async getUsers({ commit }) {
        return await UserService
            .getUsers()
            .then(response => {
                const { data, meta } = response.data;
                commit('ADD_USERS', { data, meta });
            })
    },
    async storeUser({ commit }, params) {
        await UserService
            .register(params)
            .then(() => {
                notify({
                    title: "Deu certo",
                    text: "Usuário registrado com sucesso",
                    type: "success",
                  });
            })
            .finally(() => {
                window.location.href = "http://localhost:5173/login"
            })
    },
});
