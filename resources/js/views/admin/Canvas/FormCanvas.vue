<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <Modal @update:go-function="deleteData" label="Delete" />
            <form @submit.prevent="handleSubmit" class="mt-4 space-y-3">
                <div>
                    <Select label="Refrensi Pemilih" :data="real" v-model="form.parentId" :search="form.parentId"
                        @update:search="form.parentId = $event"></Select>
                </div>
                <div class="border border-gray-200">
                    <div class="">
                        <p class="p-2  bg-white">Pemilih Utama</p>
                    </div>
                    <div class="p-4 space-y-3">
                        <Select label="Desa / Kelurahan" :data="villages" v-model="form.villageId" :search="form.villageId"
                            @update:search="form.villageId = $event">
                        </Select>
                        <Input label="Nama Pemilih" v-model="form.name" required></Input>
                        <Input label="NIK Pemilih" type="number" v-model="form.nik" required></Input>
                        <Input label="NKK Pemilih" type="number" v-model="form.nkk" required></Input>
                        <Input label="Nomor Telfon Pemilih" v-model="form.phone"></Input>
                        <div class="flex space-x-4">
                            <Input class="basis-1/2" label="RT" v-model="form.rt"></Input>
                            <Input class="basis-1/2" label="RW" v-model="form.rw"></Input>
                        </div>
                        <div class="flex flex-col ">
                            <label for="">Alamat</label>
                            <textarea class="mt-2 form-control" v-model="form.address"></textarea>
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
                <div v-for="(item, index) in  form.real ">
                    <div class="border border-gray-200">
                        <div>
                            <p class="p-2 bg-white">Relasi Pemilih {{ index + 1 }}</p>
                        </div>
                        <div class="p-4 space-y-3">
                            <Input :label="`Nama relasi ${index + 1}`" v-model="form.real[index].name"></Input>
                            <Input :label="`NIK relasi ${index + 1}`" v-model="form.real[index].nik"></Input>
                            <Input :label="`NKK relasi ${index + 1}`" v-model="form.real[index].nkk"></Input>
                            <div>
                                <label for="">Foto KTP relasi {{ index + 1 }}</label>
                                <ImageUpload v-model="form.real[index].ktp"
                                    @update:imageInput="form.real[index].ktp = $event" :imageData="relPict.ktp[index]" />
                            </div>
                            <div>
                                <label for="">Foto KK relasi {{ index + 1 }}</label>
                                <ImageUpload v-model="form.real[index].kk" @update:imageInput="form.real[index].kk = $event"
                                    :imageData="relPict.kk[index]" />
                            </div>
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
        // const assignmentStore = useAssignmentStore()
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const id = route.params.id

        const { getReal, real, getVillages, villages, storeCanvas, showCanvas, canvases } = useCanvasComposables()
        const isLoading = ref(true)
        const create = ref(true)
        const withImage = ref('')
        const rumah = ref('')
        const ktp = ref('')
        // const ktp1 = ref('')
        // const ktp2 = ref('')
        const kk = ref('')
        const relPict = ref({
            ktp: [
                '',
                '',
            ],
            kk: [
                '',
                ''
            ]
        })
        // const kk1 = ref('')
        // const kk2 = ref('')
        const form = ref({
            real: [
                {},
                {}
            ]
        })
        const fetchEdit = async () => {
            console.log(form.value)
            await getReal()
            await fetchVillage()
            await showCanvas(id)
            form.value = canvases.value

            create.value = false
            isLoading.value = false
        }
        const fetchData = async () => {
            await getReal()
            console.log(real.value)
            await fetchVillage()
            isLoading.value = false
        }

        const fetchVillage = async (id) => {
            await getVillages(id)
        }

        const deleteData = async () => {
            // console.log(data.value.id);
            await deleteAssignment(id);
            await router.push('/admin/canvas')
            alert.showAlert('Data berhasil dihapus')
        };

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (!create.value) {
                    console.log("edit");
                    await storeCanvas(form.value, true, route.params.id);
                } else {
                    // console.log("tambah");
                    await storeCanvas(form.value, false);
                }
                router.push('/admin/canvas')
                isLoading.value = false
            } catch (e) {
                console.log(e)
                isLoading.value = false
                return
            }
        }

        watch(form, (newForm) => {
            console.log(newForm)
        }, { deep: true })


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
            real,
            villages,
            deleteData,
            handleSubmit,
            id,
            ktp,
            relPict,
            kk,
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
