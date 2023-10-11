import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function assignmentComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const assignments = ref('');
    const district = ref([])
    const dapil = ref([])
    const user = ref([])
    // const showAssignment = ref()
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getAssignment = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/assignment?page=' + page + '&limit=' + size + '&' + params, 'get', null, newToken)
            // console.log(response)
            assignments.value = response
        } catch (e) {
            throw e
        }
    }

    const getUser = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/assignment/user', 'get', null, newToken)
            user.value = response.data
        } catch (e) {
            throw e
        }
    }
    const storeAssignment = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            formData.append('userId', form.users.id);
            formData.append('dapilDistrictId', form.dapilDistricts);
            formData.append('districtId', form.districts.id);
            console.log(form)
            let url = '/api/assignment/'
            if (edit) {
                url = '/api/assignment/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, newToken);

        } catch (e) {
            console.log(e)
            throw e
        }
    }
    const getDistrict = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/assignment/district?id=' + id, 'get', null, newToken)
            district.value = response.data
        } catch (e) {
            throw e
        }
    }
    const getDapil = async () => {
        try {
            const response = await useBase.fetchData2('/api/assignment/dapil', 'get', null, newToken)
            console.log(response)
            dapil.value = response.data
        } catch (e) {
            throw e
        }
    }

    const showAssignment = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/assignment/show/' + id, 'get', null, newToken)
            assignments.value = response
        } catch (e) {
            throw e
        }
    }

    const deleteAssignment = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/assignment/delete/' + id, 'post', null, newToken)
            // assignments.value = response
        } catch (e) {
            throw e
        }
    }
    const updateAssignment = async (form, edit = false, id = null, token) => {
        try {
            const formData = new FormData();
            for (const key in form) {
                formData.append(key, form[key]);
            }
            let url = '/api/assignment/'
            if (edit) {
                url = '/api/assignment/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, token);

        } catch (e) {
            console.log(e)
            throw e
        }
    }

    return {
        assignments,
        dapil,
        district,
        user,
        storeAssignment,
        getUser,
        getDapil,
        getDistrict,
        getAssignment,
        deleteAssignment,
        updateAssignment,
        showAssignment
    }
}
