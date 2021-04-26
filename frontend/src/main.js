import { createApp } from 'vue'
import App from './App.vue'
import './assets/materialize.js'

import {API_HOST} from "@/constants"

import axios from 'axios'

import router from './router'
import store from '@/store'

axios.defaults.withCredentials = true
axios.defaults.baseURL = API_HOST

// axios.interceptors.request.use(
//   (config) => {
//     let token = localStorage.getItem('token')

//     if (token) {
//       config.headers['Authorization'] = `Bearer ${ token }`
//     }

//     return config
//   },

//   (error) => {
//     return Promise.reject(error)
//   }
// )

const app = createApp(App)
app.use(router)
app.use(store)
app.mount('#app')

// Vue.prototype.$http = Axios;
// const token = localStorage.getItem('token')
// if (token) {
//   Vue.prototype.$http.defaults.headers.common['Authorization'] = token
// }
