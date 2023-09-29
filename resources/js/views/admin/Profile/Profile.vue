<template>
    <div>
        <Button typeButton="link" href="/profile/changepassword" class="mb-4" width="inline">Ganti Password</Button>
        <Accordion flush class="accordian-akm">
            <AccordionPanel>
                <AccordionHeader class="accordian-header">
                    <p class="text-md">Profile</p>
                </AccordionHeader>
                <AccordionContent class="accordian-content">
                    <form @submit.prevent="handleSubmit" class="space-y-3">
                        <div>
                            <label for="">Foto Profile</label>
                            <ImageUpload v-model="form.avatar" @update:imageInput="form.avatar = $event"
                                :imageData="imageData" :defaultImage="Avatar" />
                        </div>
                        <Input label="Nama" v-model="form.name" />
                        <Input label="Username" v-model="form.username" />
                        <Input label="No. Telfon" v-model="form.phone" />
                        <div>
                            <label for="">Alamat </label>
                            <textarea class="form-control mt-2 w-full" label="Alamat" v-model="form.address"></textarea>
                        </div>
                        <Button type="submit">Update data profile</Button>
                    </form>
                </AccordionContent>
            </AccordionPanel>
            <accordion-panel v-if="!authStore.authUser.admin">
                <accordion-header class="accordian-header">
                    <p>Penugasan</p>
                </accordion-header>
                <accordion-content class="accordian-content">
                    <div v-if="fullMeData && fullMeData.assignment" class="space-y-3">
                        <div>
                            <label for="">Provinsi</label>
                            <p>{{ fullMeData.assignment[0].province.name }}</p>
                        </div>
                        <div>
                            <label for="">Kota</label>
                            <p>{{ fullMeData.assignment[0].city.name }}</p>
                        </div>
                        <div>
                            <label for="">Kota</label>
                            <p>{{ fullMeData.assignment[0].district.name }}</p>
                        </div>
                        <div>
                            <label for="">Desa</label>
                            <div>
                                <p v-for="(desa, index) in fullMeData
                                    .assignment[0].district.villages" class="inline">
                                    <span v-if="index !== 0">, </span>{{ desa.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </accordion-content>
            </accordion-panel>
        </Accordion>
    </div>
</template>
<script>
import { useAuthStore } from "@/store";
import {
    Accordion,
    AccordionPanel,
    AccordionHeader,
    AccordionContent,
} from "flowbite-vue";
import { Avatar } from "@/assets/index.js";
import { Input, ImageUpload, Card, Button } from "../../../components";
import { onUnmounted, computed, onMounted, ref, watch } from "vue";
import { onBeforeRouteLeave } from "vue-router";
export default {
    setup() {
        const authStore = useAuthStore();

        const imageData = ref(null);
        const change = ref(false);
        // const fullMeData = ref(null);

        const fullMeData = ref({
            assignment: [
                {
                    province: {
                        name: "",
                    },

                    city: {
                        name: "",
                    },

                    district: {
                        name: "",
                    },
                },
            ],
        });
        const form = ref({
            name: "",
            username: "",
            phone: "",
            avatar: "",
        });
        const originalForm = {
            name: "",
            username: "",
            phone: "",
        };
        const handleSubmit = async () => {
            try {
                await authStore.updateUser(form.value);
                change.value = false;
            } catch (e) {
                console.log(e);
            }
        };
        const fetchData = async () => {
            await authStore.getFullMe();
            const data = await authStore.fullMe;
            const data2 = await authStore.authUser;
            fullMeData.value = await data;
            // console.log(fullMeData);
            // if(fullMeData.)
            console.log(fullMeData.value);
            // form.value = data2;
            imageData.value = data2.avatar;
            console.log(imageData.value)
            Object.assign(originalForm, data2);
            Object.assign(form.value, data2);
            form.value.avatar = "";
        };
        watch(
            form,
            (newForm) => {
                const newData = Object.assign({}, newForm);
                // const originData1 = JSON.stringify(originalForm);
                // const newData1 = newData;
                const originData2 = { ...originalForm };
                delete originData2.avatar;
                const newData2 = { ...newData };
                delete newData2.avatar;
                console.log(originData2);
                console.log(newData2);
                console.log(newData.avatar);
                if (JSON.stringify(originData2) !== JSON.stringify(newData2)) {
                    if (newData.avatar) {
                        change.value = true;
                    }
                    change.value = true;
                    console.log(change.value);
                }
            },
            { deep: true }
        );
        onMounted(async () => {
            await fetchData();
            // console.log(change.value);
        });
        // onBeforeRouteLeave(async () => {
        //     if (change.value == true) {
        //         alert("apa kamu yakin ingin keluar?");
        //     }
        // });
        return {
            fullMeData,
            form,
            Avatar,
            imageData,
            authStore,
            handleSubmit,
        };
    },
    components: {
        Input,
        Button,
        ImageUpload,
        Card,
        Accordion,
        AccordionPanel,
        AccordionHeader,
        AccordionContent,
    },
};
</script>
