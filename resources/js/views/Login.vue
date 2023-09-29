<template>
    <div class="flex justify-center relative px-8 xl:px-0">
        <div class="w-96 h-full px-5 rounded-xl xl:shadow">
            <!-- <div class="border-b border-slate-700 pb-5 text-center">
                <p class="text-rkRed font-semibold">Welcome to Rkf Official</p>
            </div> -->
            <div class="flex justify-center">
                <div class="pb-5 flex flex-col items-center">
                    <img :src="Logo" class="w-[150px]" alt="" />
                    <p class="text-rkRed font-semibold text-2xl mt-2">
                        Welcome Back!
                    </p>
                </div>
            </div>
            <template v-if="error">
                <Alert type="danger" class="mt-5">{{ error }} </Alert>
            </template>
            <form @submit.prevent="handleLogin">
                <div class="mt-5 mb-2">
                    <!-- <input type="text" v-model="form.username" /> -->
                    <Input required v-model="form.username" placeholder="Username" />
                </div>
                <div class="">
                    <Input required v-model="form.password" type="password" placeholder="Password" />
                </div>
                <!-- <a href="javascript:;" type="button">Submit</a> -->
                <Button typeButton="submit" class="mt-8">
                    <spinner v-if="isLoading" color="white" size="6" />
                    <p v-else>Masuk</p>
                </Button>
            </form>
        </div>
    </div>
</template>
<script>
// throw new Error("bad_error");
import { ref, watch, computed, onMounted } from "vue";
import { Input, Button } from "../components";
// const InputAkm = () => import("@/components/Form/InputAkm.vue");
// try {
//     const InputAkm = () => import("@/components/Form/InputAkm.vue");
// } catch (e) {
//     throw new Error(e);
// }
// const Button = () => import("@/components/Admin/Button/Button.vue");
import { useAuthStore } from "@/store";
import { Alert } from "flowbite-vue";
import { Logo } from "@/assets";
import { Spinner } from 'flowbite-vue'
// import { ref } from "vue";

export default {
    setup() {
        const useAuth = useAuthStore();
        const token = computed(() => useAuth.token);
        const error = computed(() => useAuth.error);
        const isLoading = ref(false)
        const handleLogin = async () => {
            isLoading.value = true
            await useAuth.handleLogin(form.value)
            isLoading.value = false
        }
        const form = ref({
            username: "",
            password: "",
        });
        watch(error, () => {
            form.value.password = "";
        });
        return {
            form,
            useAuth,
            token,
            error,
            isLoading,
            handleLogin
        };
    },
    data() {
        return {
            Logo,
        };
    },
    components: {
        Input,
        Button,
        Alert,
        Spinner
    },
};
</script>
