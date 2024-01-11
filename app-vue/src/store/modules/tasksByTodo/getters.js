export default ({
  allTasksByTodo  : state => state.tasksByTodo,
  tasksIsNotDone  : (state) => state.tasksByTodo?.filter(task => task.is_completed !== 1),
});
  