import BaseService from "./base.service"
import { TOKEN_NAME } from '../configs'
export default class AuthService extends BaseService {
    static async auth (params) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('/login', params)
                .then(response => {
                    localStorage.setItem(TOKEN_NAME, response.data.access_token)
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static async register (params) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('/register', params)
                .then(response => {
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }
    
    static async getMe () {
        const token = localStorage.getItem(TOKEN_NAME)

        if (!token) {
            return Promise.reject('Token Not Found')
        }

        return new Promise((resolve, reject) => {
            this.request({auth: true})
                .get('/me')
                .then(response => resolve(response.data.data))
                .catch(error => {
                    localStorage.removeItem(TOKEN_NAME)
                    reject(error.response)
                })
        })
    }
    
    static async updateMe(userId, updatedInfo) {
        return new Promise((resolve, reject) => {
            this.request({auth: true})
                .put(`/me/${userId}/update`, updatedInfo)
                .then((response) => resolve(response.data.data))
                .catch(error => reject(error.response))
        })
    }
    
    static async logout () {
        return new Promise((resolve, reject) => {
            this.request({auth: true})
                .post('/logout')
                .then(() => {
                    localStorage.removeItem(TOKEN_NAME)
                    resolve('ok')
                })
                .catch(error => reject(error.response))
        })
    }
}