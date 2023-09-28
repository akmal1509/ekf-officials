import { createWebHistory, createRouter } from "vue-router";
import { useAuthStore, useSidebarStore, useStepOneStore } from "./store";
import { CreateSurveySekolah, DapilCategory, Dashboard, Login, ShowSurveySekolah, SurveySekolah, Maintenance, Profile } from "./views";
import { AdminLayout, AuthLayout, BaseLayout, FrontLayout } from "./layout";
import { checkAuth, checkSurveySekolahOwnership, guestOnly, requireAuth } from "./plugins/Middleware/middleware";


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
                middleware: [guestOnly]
            },
        }]
    },
    {
        path: '/maintenance',
        component: Maintenance
    },
    {
        path: '/admin',
        redirect: '/admin/dashboard',
        component: AdminLayout,
        meta: {
            middleware: [requireAuth]
        },
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard
            },
            {
                path: 'profile',
                name: 'profile',
                component: Profile
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
                        path: 'edit/:id',
                        name: 'EditSurveySekolah',
                        component: CreateSurveySekolah,
                        props: { key: 'create' },
                        // beforeRouteLeave(to, from, next) {
                        //     const stepOneStore = useStepOneStore()
                        //     stepOneStore.removeState()
                        //     console.log('halo')
                        //     next();
                        // },
                        meta: {
                            middleware: [checkSurveySekolahOwnership]
                        },
                    },
                    {
                        path: 'create',
                        name: 'CreateSurveySekolah',
                        component: CreateSurveySekolah,
                        props: { key: 'update' }
                    },
                    {
                        path: ':id',
                        name: 'ShowSurveySekolah',
                        component: ShowSurveySekolah,
                        beforeRouteLeave(to, from, next) {
                            const stepOneStore = useStepOneStore()
                            stepOneStore.removeState()
                            console.log('halo')
                            next();
                        },
                        meta: {
                            middleware: [checkSurveySekolahOwnership]
                        },
                    },

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
    scrollBehavior() {
        return { top: 0 }; // Ini akan menggulirkan halaman ke atas setiap kali berganti route
    },
    routes
});

router.beforeEach((to, from, next) => {
    // Anda dapat memeriksa apakah rute saat ini atau rute tujuan memiliki properti meta yang mengandung middleware yang diperlukan
    const isSidebar = useSidebarStore().sidebarOpen;
    if (isSidebar) {
        useSidebarStore().toggleSidebar()
    }
    const middleware = to.meta.middleware || [];
    const context = { to, from, next };


    // Jalankan middleware secara berurutan menggunakan reduceRight
    middleware.reduceRight((nextMiddleware, currentMiddleware) => {
        return () => {
            currentMiddleware(context, nextMiddleware);
        };
    }, next)();
});




export default router;
