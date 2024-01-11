import BaseService from "./base.service"

export default class DashboardService extends BaseService {
    static getTasks() {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .get('/dashboard/tasks')
                .then(response => resolve(response))
                .catch(error => reject(error.response))
        })
    }
}