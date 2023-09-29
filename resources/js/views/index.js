// import Login from './Login.vue'
// import Dashboard from '@/views/admin/Dashboard.vue'
import { SurveySekolah, CreateSurveySekolah, DapilCategory, ShowSurveySekolah, Dashboard } from './admin'
const Maintenance = () => import('./Maintenance.vue')
const Login = () => import('./Login.vue')
const Profile = () => import('./admin/Profile/Profile.vue')
const User = () => import('./admin/User/User.vue')
const ChangePassword = () => import('./admin/Profile/ChangePassword.vue')
// const Dashboard = () => import('./admin')

export { Login, Dashboard, DapilCategory, SurveySekolah, CreateSurveySekolah, ShowSurveySekolah, Maintenance, Profile, User, ChangePassword }
