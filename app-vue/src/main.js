import { createApp } from 'vue'
import '@/assets/css/tailwind.css'

import App from './App.vue'
import router from '@/router'
import Vuex from 'vuex'
import store from './store'
import Notifications from '@kyvg/vue3-notification'

const app = createApp(App)
app.use(Notifications)
app.use(store)
app.use(router)
app.use(Vuex)
app.mount('#app')
