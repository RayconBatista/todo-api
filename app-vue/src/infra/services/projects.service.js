import BaseService from "./base.service"

export default class ProjectService extends BaseService {
  static getProjects() {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get('/projects')
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static getProject(id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get(`/projects/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static destroyProject(id) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .delete(`/projects/${id}`)
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}