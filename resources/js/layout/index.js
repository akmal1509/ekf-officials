// import AdminLayout from './AdminLayout.vue'
// import AuthLayout from './AuthLayout.vue'
// import FrontLayout from './FrontLayout.vue'
// import BaseLayout from './BaseLayout.vue'

const AdminLayout = () => import('./AdminLayout.vue')
const AuthLayout = () => import('./AuthLayout.vue')
const FrontLayout = () => import('./FrontLayout.vue')
const BaseLayout = () => import('./BaseLayout.vue')

export { AdminLayout, AuthLayout, FrontLayout, BaseLayout }
