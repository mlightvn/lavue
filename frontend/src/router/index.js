import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue')
  },

  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/Authentication/Register.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Authentication/Login.vue')
  },

  {
    path: "/:catchAll(.*)",
    name: "not_found",
    component: () => import('@/views/error/404.vue'),
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
