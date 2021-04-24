import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/materialize.js'

// import '@/assets/styles/constants.less'

createApp(App).use(router).mount('#app')
