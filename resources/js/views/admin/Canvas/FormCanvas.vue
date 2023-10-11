<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <Modal @update:go-function="deleteData" label="Delete" />
            <form @submit.prevent="handleSubmit" class="mt-4 space-y-3">
                <div>
                    <Select label="Refrensi Pemilih" :data="real"></Select>
                </div>
                <div class="border border-gray-200">
                    <div class="">
                        <p class="p-2  bg-white">Pemilih Utama</p>
                    </div>
                    <div class="p-4 space-y-3">
                        <Select label="Desa / Kelurahan" :data="villages"></Select>
                        <Input label="Nama Pemilih" v-model="form.name" required></Input>
                        <Input label="NIK Pemilih" v-model="form.nik" required></Input>
                        <Input label="NKK Pemilih" v-model="form.nkk" required></Input>
                        <Input label="Nomor Telfon Pemilih" v-model="form.phone"></Input>
                        <div class="flex space-x-4">
                            <Input class="basis-1/2" label="RT" v-model="form.phone"></Input>
                            <Input class="basis-1/2" label="RW" v-model="form.phone"></Input>
                        </div>
                        <div class="flex flex-col ">
                            <label for="">Alamat</label>
                            <textarea class="mt-2 form-control"></textarea>
                        </div>
                        <Input label="Tps" type="number" v-model="form.tps"></Input>
                        <div>
                            <label for="">Foto KTP Pemilih</label>
                            <ImageUpload v-model="form.ktp" @update:imageInput="form.ktp = $event" :imageData="ktp" />
                        </div>
                        <div>
                            <label for="">Foto KK Pemilih</label>
                            <ImageUpload v-model="form.kk" @update:imageInput="form.kk = $event" :imageData="kk" />
                        </div>
                        <div>
                            <label for="">Foto bersama pemilih</label>
                            <ImageUpload v-model="form.with" @update:imageInput="form.withImage = $event"
                                :imageData="withImage" />
                        </div>
                        <div>
                            <label for="">Foto rumah pemilih</label>
                            <ImageUpload v-model="form.rumah" @update:imageInput="form.rumah = $event" :imageData="rumah" />
                        </div>
                    </div>
                </div>
                <div class="border border-gray-200">
                    <div>
                        <p class="p-2 bg-white">Relasi Pemilih 1</p>
                    </div>
                    <div class="p-4 space-y-3">
                        <Input label="Nama relasi 1" v-model="form.realName1"></Input>
                        <Input label="NIK relasi 1" v-model="form.realNik1"></Input>
                        <Input label="NKK relasi 1" v-model="form.realNkk1"></Input>
                        <div>
                            <label for="">Foto KTP relasi 1</label>
                            <ImageUpload v-model="form.ktp1" @update:imageInput="form.ktp1 = $event" :imageData="ktp1" />
                        </div>
                        <div>
                            <label for="">Foto KK relasi 1</label>
                            <ImageUpload v-model="form.kk1" @update:imageInput="form.kk1 = $event" :imageData="kk1" />
                        </div>
                    </div>
                </div>
                <div class="border border-gray-200">
                    <div>
                        <p class="p-2 bg-white">Relasi Pemilih 2</p>
                    </div>
                    <div class="p-4 space-y-3">
                        <Input label="Nama relasi 2" v-model="form.relName2"></Input>
                        <Input label="NIK relasi 2" v-model="form.relNik2"></Input>
                        <Input label="NKK relasi 2" v-model="form.relNkk"></Input>
                        <div>
                            <label for="">Foto KTP relasi 2</label>
                            <ImageUpload v-model="form.ktp2" @update:imageInput="form.ktp2 = $event" :imageData="ktp2" />
                        </div>
                        <div>
                            <label for="">Foto KK relasi 2</label>
                            <ImageUpload v-model="form.kk2" @update:imageInput="form.kk2 = $event" :imageData="kk2" />
                        </div>
                    </div>
                </div>
                <div>
                    <Button class="mt-5">Submit</Button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed, watch } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal } from "@/components";
import { useAssignmentStore, useAlertStore } from '@/store'
import { useCanvasComposables } from '@/composables'
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
        const { getReal, real, getVillages, villages } = useCanvasComposables()
        const isLoading = ref(true)
        const create = ref(true)
        const withImage = ref('')
        const rumah = ref('')
        const ktp = ref('')
        const ktp1 = ref('')
        const ktp2 = ref('')
        const kk = ref('')
        const kk1 = ref('')
        const kk2 = ref('')
        const form = ref({
            users: [],
            districts: []
        })
        const fetchEdit = async () => {
            console.log(form.value)
            await fetchUser()

            create.value = false
            isLoading.value = false
        }
        const fetchData = async () => {
            await getReal()
            await fetchVillage()
            isLoading.value = false
        }

        const fetchVillage = async (id) => {
            await getVillages(id)
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
            ktp1,
            real,
            villages,
            deleteData,
            handleSubmit,
            id,
            ktp,
            ktp1,
            ktp2,
            kk,
            kk1,
            kk2,
            rumah,
            withImage
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
