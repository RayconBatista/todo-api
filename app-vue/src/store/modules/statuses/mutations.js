export default ({
    ADD_STATUS(state, statuses) {
        state.statuses = [...statuses.data]
        state.meta = statuses.meta
        state.meta.links = statuses.meta.links
    },
});