export default ({
    ADD_PROJECTS(state, projects) {
        state.projects = [...projects.data]
        state.meta = projects.meta
        state.meta.links = projects.meta.links
    },
    SET_PROJECT(state, project) {
        state.project = project.data
    },
    REFRESH_PROJECTS(state, { data, meta }) {
        state.projects.data = data;
        state.projects.meta = meta;
    },
    DELETE_PROJECT(state, id) {
        state.projects.data = state.projects.filter(project => project.id !== id);
        state.projects = [...state.projects.data]
    },
    ERROR(state, error) {
        state.error = error
    }
});