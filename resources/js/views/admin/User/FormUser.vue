<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <div class="flex space-x-3">
                <router-link to="/admin/pengguna">
                    <Button width="inline-block">Kembali</Button>
                </router-link>
                <Modal @update:go-function="deleteData" label="Delete" />
            </div>
            <form @submit.prevent="handleSubmit" class="mt-4 space-y-3">
                <Input label="Name" v-model="form.name"></Input>
                <Input label="Username" v-model="form.username"></Input>
                <Input label="Alamat" v-model="form.address"></Input>
                <Input label="No. Telfon" v-model="form.phone"></Input>
                <div v-if="create">
                    <Input label="Password" v-model="form.password"></Input>
                </div>
                <div>
                    <label for="">Foto Profile</label>
                    <ImageUpload v-model="form.avatar" @update:imageInput="form.avatar = $event" :imageData="imageData" />
                </div>
                <Button class="mt-4">Submit</Button>
            </form>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed, watch } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal } from "@/components";
import { useAuthStore, useAlertStore } from '@/store'
import { useAuthComposables } from '@/composables'
import { useRoute, useRouter } from 'vue-router';

export default {
    props: {
        id: null
    },
    setup(props) {
        const authStore = useAuthStore()
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const id = route.params.id
        const { user, showUsers, deleteUser } = useAuthComposables()
        const isLoading = ref(true)
        const create = ref(true)
        const form = ref([])
        const imageData = ref(null);
        const fetchEdit = async () => {
            await showUsers(route.params.id)
            form.value = user.value.data
            if (form.value.phone === null) {
                form.value.phone = ""
            }
            imageData.value = form.value.avatar
            console.log(form.value)
            create.value = false
            form.value.avatar = ''
            isLoading.value = false
        }
        const fetchData = async () => {
            isLoading.value = false
        }

        const deleteData = async () => {
            // console.log(data.value.id);
            await deleteUser(id);
            await router.push('/admin/pengguna')
            alert.showAlert('Data berhasil dihapus')
        };

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (!create.value) {
                    console.log("edit");
                    await authStore.storeData(form.value, true, route.params.id);
                } else {
                    // console.log("tambah");
                    await authStore.storeData(form.value, false);
                }
                // route.push('/admin/dapil/dapil-category')
                isLoading.value = false
            } catch (e) {
                console.log(e)
                isLoading.value = false
                return
            }
        }


        onMounted(() => {
            if (id) {
                fetchEdit()
            } else {
                fetchData()
            }
        })

        return {
            form,
            isLoading,
            imageData,
            deleteData,
            handleSubmit,
            user,
            id,
            create
        }
    },
    components: {
        Select,
        Input,
        Button,
        ImageUpload,
        ModalLoading,
        Modal
    },
}
</script>
