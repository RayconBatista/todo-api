import BaseService from "./base.service"

export default class UserService extends BaseService {
  static getUsers() {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get('/users')
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static async register(params) {
    console.log(params)
    return new Promise((resolve, reject) => {
      this.request()
        .post('/register', params)
        .then(response => {
          resolve(response)
        })
        .catch(error => reject(error.response))
    })
  }

  static sendInvite(email) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .post('/user/send-invite', { email: email })
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  static invites() {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get('/invites')
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}