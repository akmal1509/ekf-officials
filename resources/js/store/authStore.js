import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useAuthComposables } from "../composables";
const { getMe, loginUser, logoutUser, token, authUser, getFullMe, fullMe, updateUser } = useAuthComposables()
// const authComposables = new useAuthComposables();
export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null,
        fullMe: null,
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
                const data = await getMe(tokenStorage)
                this.authUser = data
            } catch (e) {
                this.router.push('/mejakami')
                localStorage.setItem('authToken', '')
                console.log(e)
            }
        },
        async getFullMe() {
            try {
                await getFullMe(this.getToken)
                this.fullMe = fullMe.value
            } catch (e) {
                console.log(e)
            }
        },
        async updateUser(form) {
            try {
                await updateUser(form, this.getToken, this.authUser.id)
                this.alert.showAlert('Profile berhasil diUpdate');
                console.log('aman')
                // this.route.push('admin')
            } catch (e) {
                console.log(e)
            }
        },
        async handleLogin(form) {
            try {
                const useAlert = useAlertStore();
                const authToken = await loginUser(form)
                this.token = await authToken.access_token;
                localStorage.setItem('authToken', authToken.access_token)
                await this.getMe()
                await this.router.push('/admin/dashboard')
                this.alert.showAlert('Anda Berhasil Login');

            } catch (e) {
                // this.error = 'Username atau password salah'
                console.log(e)
            }
        },
        async handleLogout() {
            try {
                console.log('logout')
                const tokenStorage = localStorage.getItem('authToken')
                await logoutUser(tokenStorage)
                localStorage.setItem('authToken', '')
                console.log('logout2')
                window.location.href = '/mejakami';
            } catch (e) {
                return e
            }
        }

    }
})
