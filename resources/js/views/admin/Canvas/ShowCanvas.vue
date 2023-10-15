<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <div class="flex">
                <router-link :to="`/admin/canvas/edit/${canvases.id}`"><Button width="inline-block">Edit</Button>
                </router-link>
                <Modal @update:go-function="deleteData" label="Delete" />
            </div>
            <div v-if="canvases.parentId !== 0" class="border border-gray-200">
                <p class="bg-white p-2">Data Refrensi</p>
                <div class="p-2 space-y-2">
                    <ShowData label="Ref Pemilih" :text="parent.name" />
                    <ShowData label="NIK Ref" :text="parent.nik" />
                    <ShowData label="NIK Ref" :text="parent.nkk" />
                </div>
            </div>
            <div v-else>
                <div class="border border-gray-200 mt-4">
                    <p class="bg-white p-2">Data Refrensi</p>
                    <div class="p-2">
                        <ShowData label="Ref Pemilih" text="Tidak ada" />
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 mt-4">
                <p class="bg-white p-2">Data Pemilih</p>
                <div class="p-2 space-y-2">
                    <ShowData label="Nama Pemilih" :text="canvases.name" />
                    <ShowData label="NIK Pemilih" :text="canvases.nik" />
                    <ShowData label="NKK Pemilih" :text="canvases.nkk" />
                    <ShowData label="No. telfon Pemilih" :text="canvases.phone" />
                    <ShowData label="Alamat Pemilih" :text="canvases.address" />
                    <ShowData label="Rt" :text="canvases.rt" />
                    <ShowData label="Rw" :text="canvases.rw" />
                    <ShowData label="Tps" :text="canvases.rw" />
                    <div class="space-y-4">
                        <p class="text-sm font-semibold">
                            Foto Ktp
                        </p>
                        <img :src="canvases.ktpImage" class="max-w-full" alt="" />
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-semibold">
                            Foto KK
                        </p>
                        <img :src="canvases.kkImage" class="max-w-full" alt="" />
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-semibold">
                            Foto Rumah
                        </p>
                        <img :src="canvases.withImage" class="max-w-full" alt="" />
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-semibold">
                            Foto Bersama Pemilih
                        </p>
                        <img :src="canvases.rumahImage" class="max-w-full" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed, watch } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal, ShowData } from "@/components";
import { useAssignmentStore, useAlertStore } from '@/store'
import { useCanvasComposables } from '@/composables'
import { useRoute, useRouter } from 'vue-router';
export default {
    setup() {
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const isLoading = ref(true);
        const id = route.params.id
        const { showCanvas, canvases, deleteCanvas } = useCanvasComposables()
        const parent = computed(() => {
            if (canvases.parentId !== 0) {
                return canvases.value.parents
            } else {
                return 'Tidak ada'
            }
        })
        const fetchData = async () => {
            await showCanvas(id)
            isLoading.value = false
            console.log(canvases)
        }
        const deleteData = async () => {
            try {
                await deleteCanvas(id);
                await router.push('/admin/canvas')
                alert.showAlert('Data berhasil dihapus')
            } catch (e) {
                console.log(e)
                return
            }

        };

        onMounted(() => {
            fetchData()
        })
        return {
            canvases,
            parent,
            isLoading,
            deleteData
        }
    },
    components: {
        ShowData,
        Button,
        Modal,
        ModalLoading
    }



}
</script>
