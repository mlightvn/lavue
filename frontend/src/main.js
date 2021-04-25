import { createApp } from 'vue'
import App from './App.vue'
import './assets/materialize.js'

import {API_HOST} from "@/constants"

import axios from 'axios'

import router from './router'
import store from '@/store'

axios.defaults.withCredentials = true
axios.defaults.baseURL = API_HOST

const app = createApp(App)
app.use(router)
app.use(store)
app.mount('#app')
