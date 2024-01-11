import TaskService from "@/infra/services/tasks.service";

export default ({
  async getTasksByTodo({ commit }, id) {
    await TaskService
      .getTasksByTodo(id)
      .then(response => {
        commit('ADD_TASKS_BY_TODO', response.data)
      })
  },

  async storeTask({ commit }, params) {
    await TaskService
      .storeTask(params)
      .then(response => {
        commit('SET_TASK_BY_TODO', response.data)
      })
  },

  async changeStatus({ commit }, params) {
    const { id } = params
    TaskService
      .changeStatus(params)
      .then((response) => {
        commit('SET_TASK_BY_TODO', id)
      })
      .catch((error) => {
        console.error('Erro ao alterar o status da tarefa', error)
      })
  },
  
  destroyTask({ commit }, id) {
    TaskService
      .destroyTask(id)
      .then(() => {
        commit('DELETE_TASK_BY_TODO', id)
        console.log('Task deletado com sucesso!')
      })
      .catch((error) => {
        console.error('Erro ao deletar o task:', error)
      })
  },
});