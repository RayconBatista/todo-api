export default ({
    ADD_TASKS_BY_TODO(state, tasksByTodo) {
        state.tasksByTodo = [...tasksByTodo.data]
        state.meta = tasksByTodo.meta
        state.meta.links = tasksByTodo.meta.links
    },
    SET_TASK_BY_TODO(state, taskByTodo) {
        state.taskByTodo = taskByTodo.data
    },
    DELETE_TASK_BY_TODO(state, id) {
        state.todos.data = state.todos.filter(todo => todo.id !== id);
        state.todos = [...state.todos.data]
    }
});