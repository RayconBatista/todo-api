import BaseService from "./base.service"

export default class UserService extends BaseService {
  static sendInvite(email) {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .post('/user/send-invite', {email: email})
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }
}