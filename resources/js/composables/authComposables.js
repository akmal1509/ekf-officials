import axios from "axios";
import { useBaseComposables, useErrorHandling } from '.'
import { ref } from "vue";



export default function useAuthComposables() {
    const { errorMessage, handleError } = useErrorHandling();

    const authUser = ref('');
    const fullMe = ref('');
    const user = ref([])
    const useBase = new useBaseComposables()
    const newToken = localStorage.getItem('authToken')
    useBase.setToken(newToken);
    const token = ref('')
    const allUser = ref('')


    const getMe = async (token) => {
        try {
            const response = await useBase.fetchMe(token);
            return response
        } catch (e) {
            throw e
        }
    }

    const showUsers = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/user/show/' + id, 'get', null, newToken)
            user.value = response
        } catch (e) {
            throw e
        }
    }

    const deleteUser = async (id) => {
        try {
            const response = await useBase.fetchData2('/api/user/delete/' + id, 'post', null, newToken)
            // assignments.value = response
        } catch (e) {
            throw e
        }
    }

    const storeData = async (form, edit = false, id = null) => {
        try {
            const formData = new FormData();
            formData.append('name', form.name);
            formData.append('username', form.username);
            formData.append('address', form.address);
            if (form.phone) {
                formData.append('phone', form.phone);
            }
            // formData.append('avatar', form.avatar);
            if (form.password) {
                formData.append('password', form.password);
            }
            if (form.avatar) {
                formData.append("avatar", form.avatar);
            }
            console.log(form)
            let url = '/api/user/'
            if (edit) {
                url = '/api/user/update/' + id
            }
            // console.log([...formData.entries()]);
            const response = await useBase.postMultiData2(url, 'post', formData, newToken);

        } catch (e) {
            console.log(e)
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

    const getAllUser = async (page, size, params) => {
        try {
            const response = await useBase.fetchData2('/api/user?page=' + page + '&limit=' + size + '&' + params, 'get', null, newToken)
            allUser.value = response

        } catch (e) {
            throw (e)
        }
    }

    const changePassword = async (form) => {
        try {
            const response = await useBase.fetchData2('/api/user/changepassword', 'post', form, newToken)
            return response
        } catch (e) {
            console.log(e)
            throw (e)
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
                formData.append("avatar", form.avatar);
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
        storeData,
        showUsers,
        user,
        authUser,
        getMe,
        loginUser,
        logoutUser,
        token,
        deleteUser,
        getFullMe,
        fullMe,
        updateUser,
        allUser,
        getAllUser,
        changePassword

    }
}
