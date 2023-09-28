import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function useAuthComposables() {
    const { errorMessage, handleError } = useErrorHandling();
    const authUser = ref('');
    const fullMe = ref('');
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);
    const token = ref('')

    const getMe = async (token) => {
        try {
            const response = await useBase.fetchMe(token);
            return response
        } catch (e) {
            throw e
        }
    }

    const getFullMe = async (token) => {
        try {
            const response = await useBase.fetchData2('/api/user/me', 'get', null, token);
            fullMe.value = response.data
        } catch (e) {
            throw e
        }
    }
    const updateUser = async (form, token, id) => {
        try {
            const formData = new FormData();
            formData.append("name", form.name);
            formData.append("username", form.username);
            formData.append("phone", form.phone);
            formData.append("address", form.address);
            if (form.avatar) {
                formData.append("avatar", form.image);
            }
            console.log([...formData.entries()]);
            const response = await useBase.postMultiData2('/api/user/update/' + id, 'post', formData, token);
            fullMe.value = response.data
        } catch (e) {
            console.log(e)
            throw e
        }
    }

    const loginUser = async (form) => {
        try {
            console.log(form)
            const response = await axios.post('/api/auth/login', form);
            // console.log(response.data)
            return response.data
            // console.log(token.value)
        } catch (error) {
            throw e
        }
    }
    const logoutUser = async (token) => {
        try {
            console.log('logoutcompo')
            // const response = await useBase.fetchMe('/api/auth/logout', 'post');
            const response = await useBase.fetchMe(token);
            return response.data;
        } catch (error) {
            throw e
        }
    }
    return {
        authUser,
        getMe,
        loginUser,
        logoutUser,
        token,
        getFullMe,
        fullMe,
        updateUser

    }
}
