// import { CreateSurveySekolah, SurveySekolah } from "./SurverSekolah";
import { CreateSurveySekolah, SurveySekolah, ShowSurveySekolah } from './SurverSekolah'
import { DapilCategory } from './Dapil'
const Dashboard = () => import('./Dashboard.vue')
const FormDapilCategory = () => import('./Dapil/FormDapilCategory.vue')
const FormDapilWilayah = () => import('./Dapil/FormDapilWilayah.vue')
const DapilWilayah = () => import('./Dapil/DapilWilayah.vue')

// import User from './User/User.vue'
// import DapilCategory from './Dapil/DapilCategory.vue'
// const CreateSurveySekolah = () => import('./SurverSekolah/')

export { CreateSurveySekolah, SurveySekolah, DapilCategory, Dashboard, ShowSurveySekolah, FormDapilCategory, FormDapilWilayah, DapilWilayah }
// export { CreateSurveySekolah, SurveySekolah, User, DapilCategory }
