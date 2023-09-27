import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useAuthComposables } from "../composables";
const authComposables = new useAuthComposables();
export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null,
        token: null,
        error: null
    }),
    getters: {
        user: (state) => state.authUser,
        getToken: () => localStorage.getItem('authToken')
    },
    actions: {
        async getMe() {
            try {
                const tokenStorage = localStorage.getItem('authToken')
                const data = await authComposables.getUser(tokenStorage)
                this.authUser = data
            } catch (e) {
                // this.router.push('/mejakami')
                localStorage.setItem('authToken', '')
                console.log(e)
            }
        },
        async handleLogin(form) {
            try {
                const useAlert = useAlertStore();
                useAlert.showAlert();
                const data = await authComposables.loginUser(form)
                this.token = data.access_token;
                localStorage.setItem('authToken', data.access_token)
                this.router.push('/admin/dashboard')

            } catch (e) {
                this.error = 'Username atau password salah'
                console.log(e)
            }
        },
        async handleLogout() {
            try {
                const tokenStorage = localStorage.getItem('authToken')
                await authComposables.logoutUser(tokenStorage)
                localStorage.setItem('authToken', '')
                window.location.href = '/mejakami';
            } catch (e) {
                return e
            }
        }

    }
})
