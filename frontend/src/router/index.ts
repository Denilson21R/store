import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import SignupView from '../views/SignupView.vue'
import LandingView from '../views/LandingView.vue'
import ClientView from '../views/ClientsView.vue'
import ProductsView from '../views/ProductsView.vue'
import SalesView from '../views/SalesView.vue'
import ProfileView from '../views/ProfileView.vue'
import NewSaleView from '../views/NewSaleView.vue'
import NewProductView from '../views/NewProductView.vue'
import DetailSaleView from '../views/DetailSaleView.vue'
import UpdateProductView from '../views/UpdateProductView.vue'
import NewClientView from '../views/NewClientView.vue'
import UpdateClientView from '../views/UpdateClientView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path: '/', name: 'landing', component: LandingView},
    {path: '/login', name: 'login', component: LoginView},
    {path: '/signup', name: 'signup', component: SignupView},
    {path: '/home', name: 'home', component: HomeView},
    {path: '/clients', name: 'clients', component: ClientView},
    {path: '/products', name: 'products', component: ProductsView},
    {path: '/sales', name: 'sales', component: SalesView},
    {path: '/sales/new', name: 'newSale', component: NewSaleView},
    {path: '/products/new', name: 'newProduct', component: NewProductView},
    {path: '/clients/new', name: 'newClient', component: NewClientView},
    {path: '/sale/:id', name: 'detailSale', component: DetailSaleView},
    {path: '/product/:id', name: 'updateProduct', component: UpdateProductView},
    {path: '/client/:id', name: 'updateClient', component: UpdateClientView},
    {path: '/profile', name: 'profile', component: ProfileView}
  ]
})

export default router
