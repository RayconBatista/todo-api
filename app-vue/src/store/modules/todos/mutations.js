export default ({
    ADD_TODOS(state, todos) {
        state.todos = [...todos.data]
        state.meta = todos.meta
        state.meta.links = todos.meta.links
    },
    REFRESH_TODOS(state, { data, meta }) {
        state.todos.data = data;
        state.todos.meta = meta;
    },
    SET_TODO(state, todo) {
        state.todo = todo.data
    },
    DELETE_TODO(state, id) {
        state.todos.data = state.todos.filter(todo => todo.id !== id);
        state.todos = [...state.todos.data]
    }
});