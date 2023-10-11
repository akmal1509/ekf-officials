import './bootstrap';
import '../scss/app.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";
import $ from 'jquery';
window.jQuery = window.$ = $;
import select2 from 'select2';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
window.select2 = select2;
// import Select2 from 'vue3-select2-component';
import { createPinia } from 'pinia'
import { createApp, markRaw } from 'vue';
import router from './router.js';
import App from './App.vue';
import jQuery from 'jquery'


const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = markRaw(router)
})


createApp(App)
    .use(pinia)
    .use(router)
    .use(ElementPlus)
    // .component('Select2', Select2)
    .mount('#app')
