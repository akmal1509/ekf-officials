<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <Modal @update:go-function="deleteData" label="Delete" />
            <form @submit.prevent="handleSubmit" class="mt-4 space-y-3">
                <Select label="User" text="Pilih User" :data="user" :search="form.users.id"
                    @update:search="form.users.id = $event"></Select>
                <Select label="Dapil Wilayah" text="Pilih Dapil Wilayah" :data="dapil" :search="form.dapilDistricts"
                    @update:search="form.dapilDistricts = $event"></Select>
                <Select label="Kecamatan" text="Pilih Kecamatan" :data="district" :search="form.districts.id"
                    @update:search="form.districts.id = $event"></Select>
                <Button class="mt-4">Submit</Button>
            </form>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed, watch } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal } from "@/components";
import { useAssignmentStore, useAlertStore } from '@/store'
import { useAssignmentComposables } from '@/composables'
import { useRoute, useRouter } from 'vue-router';

export default {
    props: {
        id: null
    },
    setup(props) {
        const assignmentStore = useAssignmentStore()
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const id = route.params.id
        const { showAssignment, assignments, getDapil, dapil, getDistrict, district, user, getUser, deleteAssignment } = useAssignmentComposables()
        const isLoading = ref(true)
        const create = ref(true)
        const form = ref({
            users: [],
            districts: []
        })
        const fetchEdit = async () => {
            await showAssignment(route.params.id)
            form.value = assignments.value.data
            console.log(form.value)
            await fetchUser()
            await fetchDapil()
            await fetchDistrict(form.value.dapilDistricts)
            create.value = false
            isLoading.value = false
        }
        const fetchData = async () => {
            await fetchDapil()
            await fetchUser()
            isLoading.value = false
        }
        const fetchDapil = async () => {
            await getDapil()
        }
        const fetchDistrict = async (id) => {
            await getDistrict(id)
        }
        const fetchUser = async () => {
            await getUser()
        }
        const deleteData = async () => {
            // console.log(data.value.id);
            await deleteAssignment(id);
            await router.push('/admin/penugasan-korcam')
            alert.showAlert('Data berhasil dihapus')
        };

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (!create.value) {
                    console.log("edit");
                    await assignmentStore.storeData(form.value, true, route.params.id);
                } else {
                    // console.log("tambah");
                    await assignmentStore.storeData(form.value, false);
                }
                // route.push('/admin/dapil/dapil-category')
                isLoading.value = false
            } catch (e) {
                console.log(e)
                isLoading.value = false
                return
            }
        }

        watch(() => form.value.dapilDistricts, async (newProv, oldProv) => {
            if (oldProv !== undefined) {
                form.value.districts.id = 0
            }
            await getDistrict(newProv)
        })

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
            deleteData,
            handleSubmit,
            dapil,
            user,
            district,
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
