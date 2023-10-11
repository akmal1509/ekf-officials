import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useAuthComposables } from "../composables";
const { getMe, loginUser, logoutUser, token, authUser, getFullMe, fullMe, updateUser, changePassword, storeData } = useAuthComposables()
// const authComposables = new useAuthComposables();
export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null,
        fullMe: null,
        token: null,
        error: null,
        errorIdent: {
            data: {
                errors: {

                }
            }
        },
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
        async storeData(form, edit, id) {
            try {

                await storeData(form, edit, id)
                // this.dapilCategory = data
                await this.router.push('/admin/pengguna')
                if (edit) {
                    this.alert.showAlert('Pengguna berhasil diUpdate');
                } else {
                    this.alert.showAlert('Pengguna berhasil di buat');
                }
            } catch (e) {
                throw e
            }
        },
        async updateUser(form) {
            try {
                await updateUser(form, this.getToken, this.authUser.id)
                this.alert.showAlert('Profile berhasil diUpdate');
                // console.log('aman')
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
                this.error = 'Username atau password salah'
                console.log(e)
            }
        },
        async changePassword(form) {
            try {
                const data = await changePassword(form)
                this.alert.showAlert('Password berhasil diubah');
                console.log(data)
                this.error = ''
            } catch (e) {
                this.errorIdent = e
                console.log(this.errorIdent)
                console.log(e)
                if (typeof e == 'object') {
                    this.error = e.response.data.errors
                } else {
                    this.error = {
                        error: [
                            'Password lama salah'
                        ]
                    }
                }
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
