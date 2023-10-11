<template>
    <div>
        <ModalLoading :isLoading="isLoading"></ModalLoading>
        <Modal @update:go-function="deleteData" label="Delete" />
        <form @submit.prevent="handleSubmit" class="mt-4">
            <Input class="text-sm" label="Nama Dapil Category" v-model="form.name"></Input>
            <Button class="mt-4">Submit</Button>
        </form>
    </div>
</template>
<script>
import { ref, onMounted, computed } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal } from "@/components";
import { useDapilCategoryStore, useAlertStore } from '@/store'
import { useDapilComposables } from '@/composables'
import { useRoute, useRouter } from 'vue-router';

export default {
    props: {
        id: null
    },
    setup(props) {
        const dapilStore = useDapilCategoryStore()
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const id = route.params.id
        const { showDapilCategory, dapilCategories, deleteDapilCategory } = useDapilComposables()
        // const id = ref('')
        const create = ref(true)
        const isLoading = ref(false)
        const form = ref({
            name: ''
        })
        const fetchEdit = async () => {
            await showDapilCategory(route.params.id)
            if (dapilCategories) {
                // console.log(route.params.id)
                form.value.name = dapilCategories.value.data.name
                // console.log(dapilCategories.value.data)
                create.value = false
            }
        }
        const deleteData = async () => {
            // console.log(data.value.id);
            await deleteDapilCategory(id);
            await router.push('/admin/dapil/dapil-category')
            alert.showAlert('Data berhasil dihapus')
        };

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (!create.value) {
                    console.log("edit");
                    await dapilStore.storeData(form.value, true, route.params.id);
                } else {
                    // console.log("tambah");
                    await dapilStore.storeData(form.value, false);
                }
                // route.push('/admin/dapil/dapil-category')
                isLoading.value = false
            } catch (e) {
                isLoading.value = false
                return
            }
        }

        onMounted(() => {
            fetchEdit()
        })

        return {
            form,
            isLoading,
            dapilStore,
            deleteData,
            handleSubmit,
            id
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
