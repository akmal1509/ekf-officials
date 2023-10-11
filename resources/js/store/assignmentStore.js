import { defineStore } from "pinia";
import { useAlertStore } from ".";
import { useAssignmentComposables } from "../composables";
const { getAssignment, assignments, storeAssignment } = useAssignmentComposables()

// const authComposables = new useAuthComposables();
export const useAssignmentStore = defineStore('Assignment', {
    state: () => ({
        assignment: null,
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

                await storeAssignment(form, edit, id)
                // this.dapilCategory = data
                await this.router.push('/admin/penugasan-korcam')
                this.alert.showAlert('Dapil Category berhasil diUpdate');
            } catch (e) {
                throw e
            }
        },
    }
})
