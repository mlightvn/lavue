import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { auth: true },
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue'),
    // meta: { guest: true },
  },

  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/Authentication/Register.vue'),
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Authentication/Login.vue'),
  },

  {
    path: '/products',
    name: 'Products',
    component: () => import('../views/Products/Index.vue'),
    meta: { auth: true },
  },

  {
    path: "/:catchAll(.*)",
    name: "not_found",
    component: () => import('@/views/error/404.vue'),
  },

]

function isAuthenticated() {
  return localStorage.getItem("user");
}

let router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isAuthenticated()) {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guest)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isAuthenticated()) {
      next({
        path: "/",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router
