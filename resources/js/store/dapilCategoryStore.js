import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useDapilComposables } from "../composables";
const { getDapilCategory, dapilCategories, storeDapilCategory } = useDapilComposables()

// const authComposables = new useAuthComposables();
export const useDapilCategoryStore = defineStore('dapilCategory', {
    state: () => ({
        dapilCategory: null,
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

                await storeDapilCategory(form, edit, id)
                // this.dapilCategory = data
                await this.router.push('/admin/dapil/dapil-category')
                this.alert.showAlert('Dapil Category berhasil diUpdate');
            } catch (e) {
                throw e
            }
        },
    }
})
