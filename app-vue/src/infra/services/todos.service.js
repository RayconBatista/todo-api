import BaseService from "./base.service"

export default class TodoService extends BaseService {
  static storeTodo(params) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .post('/todos', params)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static getTodos() {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get('/todos')
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static getTodo(id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get(`/todos/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static destroyTodo(id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .delete(`/todos/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}