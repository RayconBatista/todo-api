export default ({
  allTasks        : state => state.tasks,
  tasksIsNotDone: (state) => state.tasks?.filter(task => task.is_completed !== 1),
});
  