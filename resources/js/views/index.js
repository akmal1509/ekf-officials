// import Login from './Login.vue'
// import Dashboard from '@/views/admin/Dashboard.vue'
import { SurveySekolah, CreateSurveySekolah, DapilCategory, ShowSurveySekolah } from './admin'
const Maintenance = () => import('./Maintenance')
const Login = () => import('./Login.vue')
const Dashboard = () => import('./admin')

export { Login, Dashboard, DapilCategory, SurveySekolah, CreateSurveySekolah, ShowSurveySekolah, Maintenance }
