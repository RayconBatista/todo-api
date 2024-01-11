import { VITE_APP_TOKEN_NAME } from '@/infra/configs'
import Cookie from 'js-cookie';

const redirectIfNotAuthenticated = (to, from, next) => {
    const token = Cookie.get(VITE_APP_TOKEN_NAME);
    let n;

    if(!token) {
        n = next({ name: 'login'});
    }

    next(n);
}

const redirectIfAuthenticated = (to, from, next) => {
    const token = localStorage.getItem(VITE_APP_TOKEN_NAME);
    let n;

    if(token) {
        n = next({ name: 'home'});
    }

    next(n);
}

export {
    redirectIfNotAuthenticated,
    redirectIfAuthenticated
}