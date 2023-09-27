import './bootstrap';
import '../scss/app.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";

import { createPinia } from 'pinia'
import { createApp, markRaw } from 'vue';
import router from './router.js';
import App from './App.vue';

const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = markRaw(router)
})


createApp(App)
    .use(pinia)
    .use(router)
    .mount('#app')
