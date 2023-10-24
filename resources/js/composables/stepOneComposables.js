import { ref } from 'vue';
import { useBaseComposables } from '.'
import useErrorHandling from './errorComposables.js'
import { useRouter } from 'vue-router';
import { useAlertStore } from '../store';


export default function useStepOnesComposables() {
    // const route = useRouter();
    const alert = useAlertStore();
    const { errorMessage, handleError } = useErrorHandling()
    const countStepOnes = ref([])
    const stepOnes = ref([])
    const showStepOne = ref([])
    const villages = ref([])
    const schools = ref([])
    const isLoading = ref(true)
    // const error = ref(errorHandle)
    const useBase = new useBaseComposables();
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);

    const getStepOnes = async (page, size, params) => {
        try {
            const response = await useBase.fetchData('/api/survey-sekolah?page=' + page + '&limit=' + size + '&' + params, 'get');
            stepOnes.value = response;
            isLoading.value = false
        } catch (e) {
            console.log(e)
        }
    }
    const getCountStepOnes = async () => {
        try {
            let response = await useBase.fetchData('/api/survey-sekolah/count', 'get')
            countStepOnes.value = response.data;
            isLoading.value = false;
        } catch (e) {
            console.log(e)
        }
    }
    const getVillages = async () => {
        try {
            let response = await useBase.fetchData('/api/survey-sekolah/villages', 'get')
            villages.value = response.data;
            isLoading.value = false;
        } catch (e) {
            console.log(e)
        }
    }
    const getSchools = async (id) => {
        try {
            // console.log(id)
            let response = await useBase.fetchData('/api/survey-sekolah/schools?id=' + id, 'get')
            // console.log(response)
            schools.value = response.data;
            isLoading.value = false;
        } catch (e) {
            console.log(e)
        }
    }
    const getStepOneShow = async (id) => {
        try {
            let response = await useBase.fetchData('/api/survey-sekolah/show/' + id, 'get')
            // console.log(response)
            showStepOne.value = response.data;
            isLoading.value = false;
        } catch (e) {
            console.log(e)
        }
    }
    const deleteStepOneData = async (id) => {
        try {
            let response = await useBase.fetchData('/api/survey-sekolah/delete/' + id, 'post')
            // console.log(response)
            showStepOne.value = response.data;
            isLoading.value = false;
        } catch (e) {
            console.log(e)
        }
    }
    const postStepOne = async (form, edit = false, id) => {
        try {

            const formData = new FormData();
            formData.append("villageId", form.villageId);
            formData.append("schoolId", form.schoolId);
            formData.append("schoolName", form.schoolName);
            formData.append("headmaster", form.headmaster);
            formData.append("phoneHeadmaster", form.phoneHeadmaster);
            formData.append("schoolOperator", form.schoolOperator);
            formData.append("phoneOperator", form.phoneOperator);
            formData.append("chairman", form.chairman);
            formData.append("phoneChairman", form.phoneChairman);
            if (form.image) {
                formData.append("image", form.image);
            }
            console.log([...formData.entries()]);
            let url = '/api/survey-sekolah/'
            if (edit) {
                url = '/api/survey-sekolah/update/' + id
            }
            // console.log(url)
            let response = await useBase.postMultiData(url, 'post', formData)
            // console.log(response)
            isLoading.value = false;
        } catch (e) {
            // this.errorStepOne = e.response.data
            handleError(e.response.data)
            throw e.response.data
            // console.log(e)
            // throw new Error(e);
        }
    }


    return {
        isLoading,
        stepOnes,
        getStepOnes,
        postStepOne,
        getCountStepOnes,
        countStepOnes,
        getVillages,
        villages,
        getSchools,
        schools,
        postStepOne,
        showStepOne,
        getStepOneShow,
        deleteStepOneData,
        // errorStepOne,
        // errorMeesage
        errorMessage
    }
}
