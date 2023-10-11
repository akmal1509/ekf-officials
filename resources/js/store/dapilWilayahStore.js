import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useDapilWilComposables } from "../composables";
const { storeDapil } = useDapilWilComposables()

// const authComposables = new useAuthComposables();
export const useDapilWilayahStore = defineStore('dapilWilayah', {
    state: () => ({
        dapilWilayah: null,
        error: null,
        alert: useAlertStore()
    }),
    // getters: {
    //     user: (state) => state.authUser,
    //     getToken: () => localStorage.getItem('authToken')
    // },
    actions: {

        async storeData(form, edit, id) {
            try {

                await storeDapil(form, edit, id)
                // this.dapilCategory = data
                await this.router.push('/admin/dapil/dapil-wilayah')
                if (edit) {
                    this.alert.showAlert('Dapil Wilayah berhasil diUpdate');
                } else {
                    this.alert.showAlert('Dapil Wilayah berhasil di buat');
                }
            } catch (e) {
                throw e
            }
        },
    }
})
