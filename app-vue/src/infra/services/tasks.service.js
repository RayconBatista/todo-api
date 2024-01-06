import BaseService from "./base.service"

export default class TaskService extends BaseService {
  static getTasks(id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get(`todo/${id}/tasks`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static storeTask(params) {
    return new Promise(async (resolve, reject) => {
      const { id, label } = params;
      await this.request({ auth: true })
        .post(`todo/${id}/tasks`, params)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static setDone(todoId, id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .post(`todo/${todoId}/tasks/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
  static destroyTask(todoId, id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .delete(`todo/${todoId}/tasks/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}