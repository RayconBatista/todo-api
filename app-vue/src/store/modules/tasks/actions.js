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