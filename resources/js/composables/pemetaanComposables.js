import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function usePemetaanComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const pemetaan = ref('');
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getPemetaan = async (params) => {
        try {
            const response = await useBase.fetchData2('/api/survey-sekolah/pemetaan?' + params, 'get', null, newToken)
            pemetaan.value = response
        } catch (e) {
            throw e
        }
    }

    return {
        pemetaan,
        getPemetaan,
    }
}
