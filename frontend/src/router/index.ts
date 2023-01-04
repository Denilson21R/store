import { createRouter, createWebHistory } from 'vue-router'
import Landing from '../views/Landing.vue'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import SignupView from '../views/SignupView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path: '/', name: 'landing', component: Landing},
    {path: '/login', name: 'login', component: LoginView},
    {path: '/signup', name: 'signup', component: SignupView},
    {path: '/home', name: 'home', component: HomeView}
  ]
})

export default router
