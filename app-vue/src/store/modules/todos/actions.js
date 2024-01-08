import TodoService from "@/infra/services/todos.service";

export default ({
  async setTodo({ commit }, id) {
    await TodoService
      .getTodo(id)
      .then(response => {
        commit('SET_TODO', response.data)
      })
  },
  async getTodos({ commit }) {
    await TodoService
      .getTodos()
      .then(response => {
        const { data, meta } = response.data;
        commit('ADD_TODOS', response.data)
        commit('REFRESH_TODOS', { data, meta })
      })
  },
  async storeTodo({ commit }, params) {
    await TodoService
      .storeTodo(params)
      .then(response => {
        commit('SET_TODO', response.data)
      })
  },
  
  destroyTodo({ commit }, id) {
    TodoService
      .destroyTodo(id)
      .then(() => {
        commit('DELETE_TODO', id)
        console.log('Todo deletado com sucesso!')
      })
      .catch((error) => {
        console.error('Erro ao deletar o todo:', error)
      })
  },
});