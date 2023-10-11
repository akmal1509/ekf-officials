import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function canvasComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const canvases = ref([]);
    const villages = ref([])
    const real = ref([])
    // const showcanvas = ref()
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getCanvas = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/canvas?page=' + page + '&limit=' + size + '&' + params, 'get', null, newToken)
            // console.log(response)
            canvases.value = response
        } catch (e) {
            throw e
        }
    }



    const getReal = async () => {
        try {
            let response = await useBase.fetchData('/api/canvas/real', 'get')
            real.value = response.data;
        } catch (e) {
            console.log(e)
        }
    }

    const getVillages = async () => {
        try {
            let response = await useBase.fetchData('/api/survey-sekolah/villages', 'get')
            villages.value = response.data;

        } catch (e) {
            console.log(e)
        }
    }
    const storecanvas = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            for (const key in form) {
                if (form[key] !== null && form[key] !== undefined && form[key] !== "") {
                    formData.append(key, form[key]);
                }
            }
            let url = '/api/canvas/'
            if (edit) {
                url = '/api/canvas/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, newToken);

        } catch (e) {
            console.log(e)
            throw e
        }
    }

    const showcanvas = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/canvas/show/' + id, 'get', null, newToken)
            canvases.value = response
        } catch (e) {
            throw e
        }
    }

    const deletecanvas = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/canvas/delete/' + id, 'post', null, newToken)
            // canvases.value = response
        } catch (e) {
            throw e
        }
    }
    const updatecanvas = async (form, edit = false, id = null, token) => {
        try {
            const formData = new FormData();
            for (const key in form) {
                formData.append(key, form[key]);
            }
            let url = '/api/canvas/'
            if (edit) {
                url = '/api/canvas/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, token);

        } catch (e) {
            console.log(e)
            throw e
        }
    }

    return {
        canvases,
        villages,
        getReal,
        storecanvas,
        getVillages,
        getCanvas,
        deletecanvas,
        updatecanvas,
        showcanvas
    }
}
