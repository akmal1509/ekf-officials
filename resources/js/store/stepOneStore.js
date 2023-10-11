import { defineStore } from "pinia";
import { useStepOnesComposables as stepCompose } from "../composables";
import { useAlertStore } from ".";

export const useStepOneStore = defineStore('steoOne', {

    state: () => ({
        stepOneData: null,
        error: null,
        isLoading: false,
        alert: useAlertStore()
    }),
    getters: {
        // stepOne: (state) =>
    },
    actions: {
        async getStepOneShow(id) {
            const { showStepOne, getStepOneShow, errorMessage } = stepCompose()
            try {
                this.isLoading = true
                await getStepOneShow(id)
                // console.log(showStepOne.value)
                this.stepOneData = { ...showStepOne.value }
                this.isLoading = false
            } catch (e) {
                this.error = errorMessage
                console.log(e)
            }
        },
        async deleteStepOneData(id) {
            const { deleteStepOneData } = stepCompose()
            try {
                await deleteStepOneData(id)
                await this.router.push('/admin/survey-sekolah')
                this.alert.showAlert('Delete data berhasil');
            } catch (e) {
                console.log(e)
            }
        },
        async storeData(data, edit, id = null) {
            const { postStepOne, errorMessage } = stepCompose()
            try {
                await postStepOne(data, edit, id)
                await this.router.push('/admin/survey-sekolah')
                this.error = ''
                if (!edit) {
                    this.alert.showAlert('Data berhasil dibuat');
                } else {
                    this.alert.showAlert('Data berhasil diedit');
                }
            } catch (e) {
                this.error = e
                throw e
            }
        },
        async removeState() {
            this.stepOneData = ''
        }

    }
})
