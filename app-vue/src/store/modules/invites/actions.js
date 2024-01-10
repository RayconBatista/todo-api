import UserService from "../../../infra/services/users.service";

export default ({
    async getInvites({ commit }) {
        return await UserService
            .invites()
            .then(response => {
                const { data, meta } = response.data;
                commit('ADD_INVITES', { data, meta });
            })
    },
});