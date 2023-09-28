import axios from 'axios';
import { useRouter } from 'vue-router';
import { getCurrentInstance } from 'vue';


class useBaseComposables {
    constructor() {
        const tokenStorage = localStorage.getItem('authToken');
        // this.router = useRouter();

        // console.log(tokenStorage)
        this.api = axios.create({
            headers: {
                Authorization: 'Bearer ' + tokenStorage,
                'Content-Type': 'application/json'
            }
        });
    }

    async fetchMe(token) {
        try {
            const response = await axios.post('/api/auth/me', null, {
                headers: {
                    Authorization: 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (e) {
            console.log(e)
            throw new Error('Error fetching data:' + e);
        }
    }
    async fetchData(endpoint, method, params = {}) {
        try {
            // console.log(this.token)
            const response = await this.api.request({
                url: endpoint,
                method: method,
                params: params
            });
            return response.data;
        } catch (e) {
            if (e.response && e.response.status === 401) {
                localStorage.setItem('authToken', '')
                window.location.href = '/mejakami';
            } else {
                console.log(e)
                throw new Error('Error fetching data:' + e);
            }

        }
    }
    async postMultiData(endpoint, method, data) {
        try {
            const response = await this.api.request({
                url: endpoint,
                method: method,
                data: data,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            console.log('aman')
            return response;
        } catch (error) {
            if (error.response.status === 401) {
                // Redirect ke halaman login atau halaman lain sesuai kebijakan Anda
                this.$router.push('/login'); // Gantilah '/login' dengan rute yang sesuai
            }
            console.log(error)
            throw error
        }
    }
}

export default useBaseComposables;
