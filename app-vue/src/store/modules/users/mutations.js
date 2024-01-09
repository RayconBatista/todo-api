export default ({
    ADD_USERS(state, users) {
        state.users = [...users.data]
        state.meta = users.meta
        state.meta.links = users.meta.links
    },
    GET_USER(state, user) {
        state.loading = true
        state.user = user

        state.loggedIn = true
        state.loading = false
    },
    UPDATE_ME(state, payload) {
        if (state.user) {
            state.user = { ...state.user, ...payload };
        }
    },
    LOGOUT(state) {
        state.user = {
            name: '',
            email: '',
        }
        state.loggedIn = false
    },
    CHANGE_LOADING(state, value) {
        state.loading = value;
    },
})
