<template>
    <div>
        <p class="text-lg font-semibold mb-2">Profile</p>
        <div class="space-y-3">
            <Input label="Nama" v-model="form.name" />
            <Input label="Username" v-model="form.username" />
        </div>
    </div>
</template>
<script>
import { useAuthStore } from "@/store";
import { Input } from "../../../components";
import { onUnmounted, computed, onMounted, ref, watch } from "vue";
export default {
    setup() {
        const authStore = useAuthStore();
        const fullMeData = computed(() => authStore.fullMe);
        const change = ref(false);
        const form = ref({
            name: "",
            username: "",
            phone: "",
        });
        const originalForm = {
            name: "",
            username: "",
            phone: "",
        };
        const fetchData = async () => {
            const data = await authStore.getFullMe();
            const data2 = await authStore.authUser;
            // form.value = data2;
            // console.log(form.value);
            // originalForm = data2;
            // originalForm = form.value;
            // console.log(form.value);
            // form.value.name = fullMeData.value.name;
            // form.value.username = fullMeData.value.username;
            // form.value.phone = fullMeData.value.phone;
            // form.value.address = fullMeData.value.address;
            // originalForm.name = form.value.name;
            // originalForm = {
            //     name: fullMeData.value.name,
            // };
            Object.assign(originalForm, data2);
            Object.assign(form.value, data2);
            // console.log(form.value);
            // console.log(originalForm);
        };
        watch(
            form,
            (newForm) => {
                const newData = Object.assign({}, newForm);
                console.log(newData);
                console.log(originalForm);
                if (JSON.stringify(originalForm) !== JSON.stringify(newData)) {
                    change.value = true;
                    console.log(change.value);
                }
            },
            { deep: true }
        );
        onMounted(() => {
            fetchData();
            // console.log(change.value);
        });

        return {
            fullMeData,
            form,
        };
    },
    components: {
        Input,
    },
};
</script>
