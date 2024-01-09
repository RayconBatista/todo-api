import AuthService from '@/infra/services/auth.service';
import ResetPasswordService from '@/infra/services/password.reset.service';
import { useNotification } from "@kyvg/vue3-notification";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const { notify } = useNotification();

export default ({
    async auth({ dispatch }, params) {
        return await AuthService.auth(params).then(() => dispatch('getMe'))
    },

    async getUsers({ commit }) {
        await AuthService
            .getUsers()
            .then(response => {
                console.log(response.data)
                commit('ADD_USERS', response.data)
            })
    },

    storeUser(params) {
        AuthService.register(params).finally(() => {
            window.location.href = "http://localhost:5173/login"
        })
    },

    async getMe({ commit }) {
        commit('CHANGE_LOADING', true)

        await AuthService.getMe()
            .then(user => {
                commit('GET_USER', user);
            })
            .finally(() => commit('CHANGE_LOADING', false))
    },

    async updateMe({ commit, state }, payload) {
        commit('CHANGE_LOADING', true)
        AuthService.updateMe(state.user.id, payload)
            .then(response => {
                commit('UPDATE_ME', response)
            })
            .finally(() => commit('CHANGE_LOADING', false))
    },

    logout({ commit }) {
        commit('CHANGE_LOADING', true)

        return AuthService.logout()
            .then(() => commit('LOGOUT'))
            .finally(() => commit('CHANGE_LOADING', false))
    },

    forgetPassword(_, params) {
        return ResetPasswordService.forgetPassword(params)
    },
});
