export default ({
    ADD_USERS(state, {data, meta}) {
        state.users = data;
        state.users.meta = meta;
    },
    // GET_USER(state, user) {
    //     state.loading = true
    //     state.user = user

    //     state.loggedIn = true
    //     state.loading = false
    // },
    // UPDATE_ME(state, payload) {
    //     if (state.user) {
    //         state.user = { ...state.user, ...payload };
    //     }
    // },
    // LOGOUT(state) {
    //     state.user = {
    //         name: '',
    //         email: '',
    //     }
    //     state.loggedIn = false
    // },
    // CHANGE_LOADING(state, value) {
    //     state.loading = value;
    // },
})
