import BaseService from "./base.service"

export default class StatusService extends BaseService {
  static getStatuses() {
    return new Promise(async (resolve, reject) => {
      await this.request({ auth: true })
        .get('/status')
        .then(response => resolve(response))
        .catch(error => reject(error.response))
    })
  }

  // static change(id, payload) {
  //   // console.log(id)
  //   return new Promise(async (resolve, reject) => {
  //     await this.request({ auth: true })
  //       .post(`tasks/${id}`, payload)
  //       .then(response => resolve(response))
  //       .catch(error => reject(error.response))
  //   })
  // }
}