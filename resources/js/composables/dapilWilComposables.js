import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function useDapilWilComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const dapilWils = ref('');
    const dapilCategories = ref([])
    const province = ref([])
    const city = ref([])
    const district = ref([])
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getDapilCategory = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/category', 'get', null, newToken)
            dapilCategories.value = response.data
        } catch (e) {
            throw e
        }
    }
    const getProvince = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/province', 'get', null, newToken)
            // dapilCategories.value = response.data
            // return response.data
            province.value = response.data
        } catch (e) {
            throw e
        }
    }
    const getCity = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/city?id=' + id, 'get', null, newToken)
            // dapilCategories.value = response.data
            // return response.data
            city.value = response.data
        } catch (e) {
            throw e
        }
    }
    const getDistrict = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/district?id=' + id, 'get', null, newToken)
            // dapilCategories.value = response.data
            district.value = response.data
            // city.value = response.data
        } catch (e) {
            throw e
        }
    }
    const getDapilWils = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah?page=' + page + '&limit=' + size + '&' + params, 'get', null, newToken)
            dapilWils.value = response
        } catch (e) {
            throw e
        }
    }
    const showDapilWils = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/show/' + id, 'get', null, newToken)
            dapilWils.value = response.data
        } catch (e) {
            throw e
        }
    }
    const deleteDapilWils = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/dapil-wilayah/delete/' + id, 'post', null, newToken)
            dapilWils.value = response
        } catch (e) {
            throw e
        }
    }
    const updateDapilWils = async (form, edit = false, id = null, token) => {
        try {
            const formData = new FormData();
            for (const key in form) {
                formData.append(key, form[key]);
            }
            let url = '/api/dapil-wilayah/'
            if (edit) {
                url = '/api/dapil-wilayah/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, token);

        } catch (e) {
            console.log(e)
            throw e
        }
    }
    const storeDapil = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            formData.append('dapilCategoryId', form.dapilCategoryId);
            formData.append('provinceId', form.provinceId);
            formData.append('cityId', form.cityId);
            formData.append('go_wil', form.go_wil);
            console.log(form)
            let url = '/api/dapil-wilayah/'
            if (edit) {
                url = '/api/dapil-wilayah/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, newToken);

        } catch (e) {
            console.log(e)
            throw e
        }
    }

    return {
        dapilWils,
        storeDapil,
        dapilCategories,
        getDapilWils,
        deleteDapilWils,
        updateDapilWils,
        getDapilCategory,
        showDapilWils,
        getProvince,
        getDistrict,
        province,
        city,
        district,
        getCity
    }
}
