import AuthService from '@/infra/services/auth.service';
import ResetPasswordService from '@/infra/services/password.reset.service';

export default ({
    async auth({ dispatch }, params) {
        return await AuthService.auth(params).then(() => dispatch('getMe'))
    },

    async getMe({ commit }) {
        commit('CHANGE_LOADING', true)

        await AuthService.getMe()
            .then(user => {
                commit('GET_USER', user)
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
