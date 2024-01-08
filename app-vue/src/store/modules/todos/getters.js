export default ({
  allTodos        : state => state.todos.data,
  getTodoSelected : state => state.todo,
  getTodoTotal    : state => state.todos?.meta.total,
});
  