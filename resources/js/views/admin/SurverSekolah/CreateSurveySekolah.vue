<template>
    <div>
        <form @submit.prevent="handleSubmit()">
            <div
                v-if="stepError"
                class="bg-red-700 p-4 rounded-md text-white space-y-3 mb-4"
            >
                <!-- {{ stepError }} -->
                <p
                    class="text-xs border-b border-[#ffffff75;] pb-3"
                    v-for="(error, i) in stepError.errors"
                >
                    {{ error[0] }}
                </p>
            </div>
            <div class="space-y-4 text-sm">
                <div class="">
                    <Select
                        label="Kelurahan/Desa"
                        text="Pilih Kelurahan"
                        :data="villages"
                        v-model="form.villageId"
                        :search="village"
                        @update:search="form.villageId = $event"
                    ></Select>
                </div>
                <div class="">
                    <Select
                        label="Sekolah"
                        depend="Pilih Desa / Kelurahan dulu"
                        text="Pilih Sekolah"
                        :data="schools"
                        v-model="form.schoolId"
                        :search="school"
                        @update:search="form.schoolId = $event"
                    ></Select>
                </div>
                <div class="space-y-4">
                    <div class="border border-gray-200">
                        <p class="mb-2 p-2 bg-white">Kelapa Sekolah</p>
                        <div class="flex space-x-4 p-2">
                            <Input
                                class="basis-1/2"
                                label="Nama Lengkap"
                                v-model="form.headmaster"
                            />
                            <Input
                                class="basis-1/2"
                                label="Nomor Telfon "
                                type="number"
                                v-model="form.phoneHeadmaster"
                            />
                        </div>
                    </div>
                    <div class="border border-gray-200">
                        <p class="mb-2 p-2 bg-white">Operator Sekolah</p>
                        <div class="flex space-x-4 p-2">
                            <Input
                                label="Nama Lengkap"
                                v-model="form.schoolOperator"
                            />
                            <Input
                                label="Nomor Telfon"
                                type="number"
                                v-model="form.phoneOperator"
                            />
                        </div>
                    </div>
                    <div class="border border-gray-200">
                        <p class="mb-2 p-2 bg-white">Ketua Komite Sekolah</p>
                        <div class="flex space-x-4 p-2">
                            <Input
                                label="Nama Lengkap"
                                v-model="form.chairman"
                            />
                            <Input
                                label="Nomor Telfon"
                                type="number"
                                v-model="form.phoneChairman"
                            />
                        </div>
                    </div>
                </div>
                <div>
                    <label for="">Foto Bersama Orang tua / Wali murid</label>
                    <ImageUpload
                        v-model="form.image"
                        @update:imageInput="form.image = $event"
                        :imageData="imageData"
                    />
                </div>
            </div>
            <Button class="mt-5" type="submit">Submit</Button>
        </form>
    </div>
</template>
<script>
import { Select, Input, Button, ImageUpload } from "@/components";
import {
    ref,
    onMounted,
    watchEffect,
    watch,
    onBeforeUnmount,
    onBeforeMount,
    computed,
} from "vue";

import { useStepOnesComposables as stepOne } from "@/composables";
import { useRouter } from "vue-router";
import { useStepOneStore } from "@/store";
export default {
    props: {
        id: null,
    },
    setup() {
        const {
            getVillages,
            villages,
            schools,
            getSchools,
            postStepOne,
            errorMessage,
        } = stepOne();
        const create = ref("true");
        const id = ref("");
        const stepOneStore = useStepOneStore();
        const stepError = computed(() => stepOneStore.error);
        // const errors = computed(() => baseStore.message);

        const route = useRouter();
        const imageData = ref(null);
        const form = ref({
            villageId: "",
            schoolId: "",
            headmaster: "",
            phoneHeadmaster: "",
            schoolOperator: "",
            phoneOperator: "",
            chairman: "",
            phoneChairman: "",
            image: null,
        });
        const village = ref("");
        const school = ref("");
        // const search = ref({
        //     village: null,
        //     school: null,
        // });

        const handleSubmit = async () => {
            // console.log(create.value);
            try {
                if (!create.value) {
                    // console.log("edit");
                    await stepOneStore.storeData(form.value, true, id.value);
                } else {
                    // console.log("tambah");
                    await stepOneStore.storeData(form.value, false);
                }
            } catch (error) {
                // console.log(errorMessage.value);
                return;
            }
        };

        const fetchVillage = async () => {
            await getVillages();
        };
        const fetchSchool = async (id) => {
            await getSchools(id);
        };
        const stepOneEdit = async () => {
            const data = await stepOneStore.stepOneData;
            if (data) {
                form.value = data;
                imageData.value = data.image;
                create.value = false;
                id.value = data.id;
                village.value = form.value.villageId;
                school.value = form.value.schoolId;
                form.value.image = "";
                console.log(imageData.value);
            }
        };
        onBeforeMount(async () => {
            stepOneEdit();
            fetchVillage();
        });
        onBeforeUnmount(async () => {
            // console.log("coba");
            await stepOneStore.removeState();
        });

        watch(
            () => form.value.villageId,
            (id) => {
                fetchSchool(id);
            }
        );
        // watch(
        //     form,
        //     (newForm) => {
        //         console.log(newForm);
        //     },
        //     { deep: true }
        // );
        return {
            form,
            villages,
            village,
            school,
            schools,
            stepOne,
            handleSubmit,
            errorMessage,
            stepError,
            imageData,
        };
    },
    components: {
        Select,
        Input,
        Button,
        ImageUpload,
    },
};
</script>
