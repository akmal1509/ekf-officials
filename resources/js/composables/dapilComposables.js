import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function dapilComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const dapilCategories = ref('');
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getDapilCategory = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-category?page=' + page + '&limit=' + size + '&' + params, 'get', null, newToken)
            dapilCategories.value = response
        } catch (e) {
            throw e
        }
    }
    const showDapilCategory = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-category/show/' + id, 'get', null, newToken)
            dapilCategories.value = response
        } catch (e) {
            throw e
        }
    }
    const deleteDapilCategory = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-category/delete/' + id, 'post', null, newToken)
            dapilCategories.value = response
        } catch (e) {
            throw e
        }
    }
    const storeDapilCategory = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            for (const key in form) {
                formData.append(key, form[key]);
            }
            let url = '/api/dapil-category/'
            if (edit) {
                url = '/api/dapil-category/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, newToken);

        } catch (e) {
            console.log(e)
            throw e
        }
    }

    return {
        dapilCategories,
        showDapilCategory,
        getDapilCategory,
        deleteDapilCategory,
        storeDapilCategory
    }
}
