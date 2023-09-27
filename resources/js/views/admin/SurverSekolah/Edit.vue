<template>
    <div>
        <form @submit.prevent="handleSubmit()">
            <div
                v-if="errorMessage"
                class="bg-red-700 p-4 rounded-md text-white space-y-3 mb-4"
            >
                <p
                    class="text-xs border-b border-[#ffffff75;] pb-3"
                    v-for="(error, i) in errorMessage.errors"
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
                        :search="search.village"
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
                        :search="search.school"
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
                                v-model="form.phoneChairman"
                            />
                        </div>
                    </div>
                </div>
                <div>
                    <label for="">Foto Bersama Orang tua / Wali murid</label>
                    <div
                        @click="openFileInput"
                        class="border border-dashed border-gray-300 p-4 mt-3 cursor-pointer"
                    >
                        <div v-if="!imagePreview" class="flex justify-center">
                            <p class="text-gray-500">
                                Klik di sini untuk memilih gambar
                            </p>
                        </div>
                        <img
                            v-else
                            :src="imagePreview"
                            alt="Pratinjau Gambar"
                            class="w-full"
                        />
                    </div>
                    <input
                        ref="imageInput"
                        type="file"
                        accept="image/*"
                        @change="handleFileChange"
                        style="display: none"
                    />
                </div>
            </div>
            <Button class="mt-5" type="submit">Submit</Button>
        </form>
    </div>
</template>
<script>
import { Select, Input, Button } from "@/components";
import {
    ref,
    onMounted,
    watchEffect,
    watch,
    onBeforeUnmount,
    computed,
} from "vue";
import { useStepOnesComposables as stepOne } from "@/composables";
import { useRoute, useRouter } from "vue-router";
import { useStepOneStore, useBaseStore } from "@/store";
export default {
    // props: {
    //     id: null,
    // },
    setup() {
        const {
            getVillages,
            villages,
            schools,
            getSchools,
            postStepOne,
            errorMessage,
        } = stepOne();
        const selectedImage = ref("");
        const edit = ref("false");
        const id = ref("");
        // const data = ref("");
        // const stepOne =
        const stepOneStore = useStepOneStore();
        const stepError = computed(() => stepOneStore.error);
        const baseStore = useBaseStore();
        // const errors = computed(() => baseStore.message);

        const route = useRouter();
        const imagePreview = ref("");
        const imageInput = ref(null);
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

        const search = ref({
            village: null,
            school: null,
        });

        const openFileInput = () => {
            // Klik pada kotak div akan mengklik input file yang tersembunyi
            imageInput.value.click();
        };

        const handleSubmit = async () => {
            console.log(edit.value);
            try {
                if (!edit.value) {
                    console.log("edit");
                    await postStepOne(form.value, true, id.value);
                } else {
                    console.log("tambah");
                    await postStepOne(form.value, false);
                }
            } catch (error) {
                console.log(errorMessage.value);
                // console.log(error);
                // console.log("ini error");
                // baseStore.setError(error);
                return;
            }
            route.push("/admin/survey-sekolah");
        };

        const handleFileChange = (event) => {
            // Ambil gambar yang dipilih
            selectedImage.value = event.target.files[0];
            form.value.image = selectedImage.value;

            // Buat tampilan pratinjau gambar
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.value = e.target.result;
            };
            reader.readAsDataURL(selectedImage.value);
        };
        const fetchVillage = async () => {
            await getVillages();
            // console.log(villages.value);
        };
        const fetchSchool = async (id) => {
            await getSchools(id);
            // console.log(schools);
        };
        const stepOneEdit = async () => {
            const data = await stepOneStore.stepOneData;
            if (data) {
                form.value = data;
                id.value = data.id;
                search.value.village = form.value.villageId;
                search.value.school = form.value.schoolId;
                imagePreview.value = data.image;
                form.value.image = "";
                // console.log(search.value.village);
            }
        };
        onMounted(() => {
            console.log("gigii");
            stepOneEdit();
            fetchVillage();
            // console.log("halo");

            imageInput.value = document.getElementById("imageInput");
        });
        onBeforeUnmount(async () => {
            console.log("coba");
            await stepOneStore.removeState();
        });

        watch(
            () => form.value.villageId,
            (id) => {
                // console.log(id);
                fetchSchool(id);
            }
        );
        watch(
            form,
            (newForm) => {
                console.log(newForm);
            },
            { deep: true }
        );
        return {
            form,
            villages,
            search,
            schools,
            openFileInput,
            handleFileChange,
            imageInput,
            imagePreview,
            stepOne,
            handleSubmit,
            errorMessage,
            stepError,
        };
    },
    components: {
        Select,
        Input,
        Button,
    },
    // watch: {
    //     "form.chairman": (newValue, oldValue) => {
    //         console.log(
    //             "Nilai form.chairman berubah dari",
    //             oldValue,
    //             "menjadi",
    //             newValue
    //         );
    //     },
    // },
};
</script>
