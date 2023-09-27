import axios from "axios";
import { useBaseComposables } from '.'

class useAuthComposables {
    constructor() {
        this.useBase = new useBaseComposables()
    }
    async getUser(token) {
        try {
            const response = await this.useBase.fetchMe('/api/auth/me', 'post', token);
            return response;
        } catch (error) {
            // console.log(e)
            throw new Error('Error fetching data:' + error);
            // return error
        }
    }

    async loginUser(form) {
        try {
            const response = await axios.post('/api/auth/login', form);
            return response.data;
        } catch (error) {
            throw new Error('Error fetching data:' + error);
        }
    }
    async logoutUser(token) {
        try {
            const response = await this.useBase.fetchMe('/api/auth/logout', 'post', token);
            return response.data;
        } catch (error) {
            throw new Error('Error fetching data:' + error);
        }
    }
}

export default useAuthComposables
