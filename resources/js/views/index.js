// import Login from './Login.vue'
// import Dashboard from '@/views/admin/Dashboard.vue'
import { SurveySekolah, CreateSurveySekolah, DapilCategory, ShowSurveySekolah, Dashboard } from './admin'
const Maintenance = () => import('./Maintenance.vue')
const Login = () => import('./Login.vue')
const Profile = () => import('./admin/Profile/Profile.vue')
const User = () => import('./admin/User/User.vue')
const ChangePassword = () => import('./admin/Profile/ChangePassword.vue')
// const Dashboard = () => import('./admin')
const Korcam = () => import('./admin/Korcam/Korcam.vue')
const FormKorcam = () => import('./admin/Korcam/FormKorcam.vue')
const FormUser = () => import('./admin/User/FormUser.vue')
const Canvas = () => import('./admin/Canvas/Canvas.vue')
const FormCanvas = () => import('./admin/Canvas/FormCanvas.vue')
const ShowCanvas = () => import('./admin/Canvas/ShowCanvas.vue')
const SampleSurveySurvey = () => import('./admin/SurverSekolah/SampleSurveySekolah.vue')

export { Login, Dashboard, DapilCategory, SurveySekolah, CreateSurveySekolah, ShowSurveySekolah, Maintenance, Profile, User, ChangePassword, Korcam, FormKorcam, FormUser, Canvas, FormCanvas, ShowCanvas, SampleSurveySurvey }
