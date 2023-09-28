import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useAuthComposables } from "../composables";
const { getMe, loginUser, logoutUser, token } = useAuthComposables()
// const authComposables = new useAuthComposables();
export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null,
        token: null,
        error: null,
        alert: useAlertStore()
    }),
    getters: {
        user: (state) => state.authUser,
        getToken: () => localStorage.getItem('authToken')
    },
    actions: {
        async getMe() {
            try {
                const tokenStorage = localStorage.getItem('authToken')
                await getMe()
                this.authUser = data
            } catch (e) {
                // this.router.push('/mejakami')
                // localStorage.setItem('authToken', '')
                // console.log(e)
            }
        },
        async handleLogin(form) {
            try {
                const useAlert = useAlertStore();
                const data = await loginUser(form)
                this.token = data;
                console.log(token)
                localStorage.setItem('authToken', this.token)
                await this.router.push('/admin/dashboard')
                this.alert.showAlert('Anda Berhasil Login');

            } catch (e) {
                this.error = 'Username atau password salah'
                // console.log(e)
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
