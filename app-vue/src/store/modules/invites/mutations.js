export default ({
    ADD_INVITES(state, {data, meta}) {
        state.invites = data;
        state.invites.meta = meta;
    },
});