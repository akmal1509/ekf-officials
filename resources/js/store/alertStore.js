import { defineStore } from "pinia";

export const useAlertStore = defineStore('alert', {
    state: () => ({
        alertOpen: false,
        message: ''
    }),
    getters: {
        isAlertOpen: (state) => state.alertOpen
    },
    actions: {
        showAlert(data) {
            this.message = data
            this.alertOpen = true
            // setTimeout(() => {
            //     this.alertOpen = true

            // }, 500)
            setTimeout(() => {
                this.closeAlert();
            }, 2000);
        },
        closeAlert() {
            this.alertOpen = false
            this.message = ''
        },
        handleMessage(data) {
            this.message = data
            this.alertOpen = true
        }
    }
})
