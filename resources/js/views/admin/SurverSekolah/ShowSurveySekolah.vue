<template>
    <div>
        <div class="flex">
            <router-link :to="`/admin/survey-sekolah/edit/${data.id}`"><Button width="inline-block"
                    class="mr-2">Edit</Button>
            </router-link>
            <Modal @update:go-function="deleteStepOne" label="Delete" />

        </div>
        <div>
            <router-link :to="`/admin/survey-sekolah/sample-data`"><Button width="inline-block" class="mt-4">Lihat Contoh
                    Data</Button>
            </router-link>
        </div>
        <div class="space-y-4 mt-4">

            <div class="border-gray-200 border rounded-sm text-sm">
                <div :class="{ 'bg-red-500': data.verify == 0, 'bg-green-600': data.verify !== 0 }">
                    <p class="p-2 font-semibold text-white">
                        Status Verifikasi : <span class="font-normal text-white">{{ data.verificate }}</span>
                    </p>

                </div>
            </div>
            <div class="border-gray-200 border rounded-sm text-sm">
                <div :class="{ 'bg-green-600': data.complete == 100.00, 'bg-red-500': data.complete !== 100.00 }">
                    <p class="p-2 font-semibold text-white">
                        Status Selesai : <span class="font-normal">{{ data.comtext }} ({{ data.complete + '%' }})</span>
                    </p>
                </div>
            </div>

            <div class="border-gray-200 border rounded-sm text-sm">
                <div class="bg-white">
                    <p class="p-2 font-semibold">
                    <div v-if="data.schools">
                        {{ data.schools.name }}
                    </div>
                    <div v-else>
                        {{ data.schoolName }}
                    </div>
                    </p>
                </div>
            </div>
            <div class="border-gray-200 border rounded-sm text-sm">
                <div class="bg-white">
                    <p class="p-2 font-semibold">
                        Jumlah pengajuan PIP : {{ data.reqPip }}
                    </p>
                </div>
            </div>

            <ShowingData :isLoading="isLoading" v-if="authStore.authUser.admin" :village="data.villages.name">
                <template v-slot:label>Korcam {{ data.villages.district.name }}</template>
                <template v-slot:nama>{{ data.users.name }}</template>
                <template v-slot:tel>{{ data.users.phone ?? '-' }}</template>
            </ShowingData>
            <ShowingData :isLoading="isLoading">
                <template v-slot:label>Kepala Sekolah</template>
                <template v-slot:nama>{{ data.headmaster }}</template>
                <template v-slot:tel>{{ data.phoneHeadmaster }}</template>
            </ShowingData>
            <ShowingData :isLoading="isLoading">
                <template v-slot:label>Operator Sekolah</template>
                <template v-slot:nama>{{ data.schoolOperator }}</template>
                <template v-slot:tel>{{ data.phoneOperator }}</template>
            </ShowingData>
            <ShowingData :isLoading="isLoading">
                <template v-slot:label>Ketua Komite</template>
                <template v-slot:nama>{{ data.chairman }}</template>
                <template v-slot:tel>{{ data.phoneChairman }}</template>
            </ShowingData>
            <div class="space-y-4">
                <p class="text-sm font-semibold">
                    Foto bersama orang tua / wali murid
                </p>
                <img :src="data.image" class="max-w-full" alt="" />
            </div>
        </div>
    </div>
</template>
<script>
import { useRouter } from "vue-router";
import { useStepOneStore, useAuthStore } from "@/store";
import { onBeforeUnmount, onMounted, computed, ref } from "vue";
import { onBeforeRouteLeave } from "vue-router";
import { ShowingData, Button, Modal } from "@/components";
export default {
    setup() {
        const stepOneStore = useStepOneStore();
        const authStore = useAuthStore()
        const data = ref({
            villages: {
                name: '',
                district: {
                    name: ''
                }
            }
        });
        const isLoading = ref(true);
        // const isLoading = computed(() => stepOneStore.isLoading);
        const fetchData = async () => {
            data.value = await stepOneStore.stepOneData;
            isLoading.value = false;
        };
        // const statusVerif = computed(()=>{
        //     if(data.value.verify == 0){
        //         return ''
        //     }
        // })
        const deleteStepOne = async () => {
            console.log(data.value.id);
            await stepOneStore.deleteStepOneData(data.value.id);
        };
        onBeforeRouteLeave(async () => {
            await stepOneStore.removeState();
        });

        onMounted(() => {
            fetchData();
        });

        return {
            data,
            deleteStepOne,
            isLoading,
            authStore
        };
    },
    components: {
        ShowingData,
        Button,

        Modal,
    },
};
</script>
