import { createWebHistory, createRouter } from "vue-router";
import { useAuthStore, useSidebarStore } from "./store";
import { CreateSurveySekolah, DapilCategory, Dashboard, Home, Login, ShowSurveySekolah, SurveySekolah, User } from "./views";
import { AdminLayout, AuthLayout, BaseLayout, FrontLayout } from "./layout";
import { checkSurveySekolahOwnership } from "./plugins/middleware/middleware";

const routes = [
    {
        path: '/',
        redirect: '/mejakami',
        component: AuthLayout,
        children: [{
            path: 'mejakami',
            name: 'login',
            component: Login,
            meta: {
                requireAuth: false
            },
        }]
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: {
            requireAuth: true
        },
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard
            },
            {
                path: 'pengguna',
                name: 'user',
                component: User
            },
            {
                path: 'survey-sekolah',
                component: BaseLayout,
                children: [
                    {
                        path: '',
                        name: 'SurveySekolah',
                        component: SurveySekolah
                    },
                    {
                        path: 'create',
                        name: 'CreateSurveySekolah',
                        component: CreateSurveySekolah
                    },
                    {
                        path: ':id',
                        name: 'ShowSurveySekolah',
                        component: ShowSurveySekolah,
                        meta: {
                            middleware: [checkSurveySekolahOwnership]
                        },
                    },
                    {
                        path: 'edit/:id',
                        name: 'EditSurveySekolah',
                        component: CreateSurveySekolah,
                        meta: {
                            middleware: [checkSurveySekolahOwnership]
                        },
                    }
                ]
            },
            {
                path: 'dapil',
                component: BaseLayout,
                children: [
                    {
                        path: '',
                        redirect: 'dapil-category'
                    },
                    {

                        path: 'dapil-category',
                        name: 'DapilCategory',
                        component: DapilCategory

                    },
                    {

                        path: 'wilayah',
                        name: 'Wilayah',
                        component: DapilCategory

                    }
                ]
            }
        ]
    },
    // { path: "/:pathMatch(.*)*", redirect: "/" },
]
const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    if (to.matched.length === 0) {
        console.log('404 - Rute tidak ditemukan:', to.fullPath);
    }
    if (to.meta.requireAuth) {
        useSidebarStore().offSidebar()
        await authStore.getMe()
        console.log('halo')
        if (authStore.authUser) {
            next()
        } else {
            next({
                name: 'login'
            })
        }
    }

    if (!to.meta.requireAuth) {
        const token = localStorage.getItem('authToken')
        // await authStore.getMe()
        if (!token) {
            next()
        } else {
            next({
                name: 'dashboard'
            })
        }
    }
    if (to.meta.middleware) {
        to.meta.middleware.forEach(middleware => {
            middleware(to, from, next);
        });
    } else {
        next();
    }
})
export default router;
