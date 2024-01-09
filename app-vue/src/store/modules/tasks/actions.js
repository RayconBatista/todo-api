import TaskService from "@/infra/services/tasks.service";

export default ({
  async getTasks({ commit }, id) {
    await TaskService
      .getTasks(id)
      .then(response => {
        commit('ADD_TASKS', response.data)
      })
  },

  async storeTask({ commit }, params) {
    await TaskService
      .storeTask(params)
      .then(response => {
        commit('SET_TASK', response.data)
      })
  },

  async changeStatus({ commit }, params) {
    const { id } = params
    TaskService
      .changeStatus(params)
      .then((response) => {
        commit('SET_TASK', id)
      })
      .catch((error) => {
        console.error('Erro ao alterar o status da tarefa', error)
      })
  },
  
  destroyTask({ commit }, id) {
    TaskService
      .destroyTask(id)
      .then(() => {
        commit('DELETE_TASK', id)
        console.log('Task deletado com sucesso!')
      })
      .catch((error) => {
        console.error('Erro ao deletar o task:', error)
      })
  },
});