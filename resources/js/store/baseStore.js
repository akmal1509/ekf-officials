import { defineStore } from "pinia";

export const useBaseStore = defineStore('base', {
    state: () => ({
        error: '',
        message: '',
    }),
    getters: {
        // isAlertOpen: (state) => state.alertOpen
    },
    actions: {
        setError(error) {
            this.error = error.errors
            this.message = error.message
        }
    }
})
