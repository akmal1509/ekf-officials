import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function useAuthComposables() {
    const { errorMessage, handleError } = useErrorHandling();
    const authUser = ref('');
    const fullMe = ref('');
    const useBase = new useBaseComposables()
    const token = ref('')

    // const getMe = async () => {
    //     try {
    //         const response = await useBase.fetchMe('/api/auth/me', 'post');
    //         // console.log(response)
    //         // return response;
    //         return response
    //     } catch (e) {
    //         throw e
    //     }
    // }
    const getMe = async (token) => {
        try {
            const response = await useBase.fetchMe(token);
            // console.log(response)
            // return response;
            return response
        } catch (e) {
            throw e
        }
    }

    const getFullMe = async () => {
        try {
            const response = await useBase.fetchData('/api/user/me', 'get');
            fullMe.value = response.data
        } catch (e) {
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
    // const loginUser = async (form) => {
    //     try {
    //         console.log(form)
    //         const response = await axios.post('/api/auth/login', form);
    //         // console.log(response.data)
    //         token.value = response.data
    //         // console.log(token.value)
    //     } catch (error) {
    //         throw e
    //     }
    // }
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
        fullMe

    }
}
