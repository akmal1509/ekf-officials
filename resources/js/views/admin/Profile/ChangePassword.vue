<template>
    <div>
        <p class="font-semibold mb-2">Ganti Passowrd</p>
        <form @submit.prevent="changePassword" class="space-y-3">
            <Alert type="danger" v-if="isError" class="">
                <!-- <div v-if="Object.keys(isError).length>1">
            <p></p>
            </div> -->
                <p v-for="(error, index) in isError"> {{ error[0] }}</p>
            </Alert>
            <Input label="Password Lama" v-model="form.oldPassword"></Input>
            <Input label="Password Baru" v-model="form.newPassword"></Input>
            <Button type="submit" class="mt-5">Submit</Button>
        </form>
    </div>
</template>

<script>
import { Input, Button } from '../../../components';
import { ref, computed } from 'vue';
import { Alert } from 'flowbite-vue';
import { useAuthStore } from '@/store'
export default {
    setup() {
        const authStore = useAuthStore()
        const isError = computed(() => authStore.error)
        const isLoading = ref(false)
        const changePassword = async () => {
            try {
                console.log('halo')
                isLoading.value = true
                await authStore.changePassword(form.value)
                isLoading.value = false
                form.value = ''
            } catch (e) {
                throw e
            }
        }
        const form = ref({
            oldPassword: '',
            newPassword: ''
        })
        return {
            authStore,
            form,
            isError,
            changePassword
        }
    },
    components: {
        Input,
        Alert,
        Button
    }
}
</script>
