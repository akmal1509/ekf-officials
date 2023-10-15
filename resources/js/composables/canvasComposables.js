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
            console.log(real.value)
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
    const storeCanvas = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            const real = form.real;
            for (const key in form) {
                if (form[key] !== null && form[key] !== undefined && form[key] !== "") {
                    if (key !== 'real') {
                        formData.append(key, form[key]);
                    } else {
                        let y = 0
                        for (let i = 0; i < real.length; i++) {
                            const item = real[i];

                            for (const key in item) {
                                if (item[key] !== null && item[key] !== undefined && item[key] !== "") {
                                    formData.append(`real[${y}][${key}]`, item[key]);
                                }
                            }
                            y++;
                        }
                    }
                }
            }
            console.log(formData)
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

    const showCanvas = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/canvas/show/' + id, 'get', null, newToken)
            canvases.value = response.data
        } catch (e) {
            throw e
        }
    }

    const deleteCanvas = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/canvas/delete/' + id, 'post', null, newToken)
            // canvases.value = response
        } catch (e) {
            throw e
        }
    }
    const updateCanvas = async (form, edit = false, id = null, token) => {
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
        real,
        getReal,
        storeCanvas,
        getVillages,
        getCanvas,
        deleteCanvas,
        updateCanvas,
        showCanvas
    }
}
