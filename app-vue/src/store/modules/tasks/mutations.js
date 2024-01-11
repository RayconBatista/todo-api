export default ({
    ADD_TASKS(state, tasks) {
        state.tasks = tasks.data
    },
    SET_TASK(state, task) {
        state.task = task.data
    },
    DELETE_TASK(state, id) {
        state.todos.data = state.todos.filter(todo => todo.id !== id);
        state.todos = [...state.todos.data]
    }
});