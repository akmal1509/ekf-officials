<template>
    <div>
        <div class="bg-gradient text-white shadow-lg rounded-2xl p-4 mb-4">
            <p class="font-semibold text-lg">Selamat Datang!</p>
            <p class="font-normal mt-4">{{ authUser.name }}</p>
        </div>
        <div v-if="!authUser.admin">
            <CardTotalData
                :data="countStepOnes.total"
                icon="school"
                label="Sekolah"
                :isLoading="isLoading"
            />
        </div>
        <div v-if="authUser.admin">
            <CardTotalData
                :data="countStepOnes.total"
                label="Sekolah"
                area="Semua Daerah"
                :isLoading="isLoading"
                icon="school"
                title
            />
            <div>
                <CardTotalData
                    :data="kuningan"
                    :isLoading="isLoading"
                    label="Sekolah"
                    icon="school"
                    area="Kuningan"
                />
                <CardTotalData
                    :data="ciamis"
                    :isLoading="isLoading"
                    label="Sekolah"
                    icon="school"
                    area="Ciamis"
                />
                <CardTotalData
                    :data="pangandaran"
                    :isLoading="isLoading"
                    label="Sekolah"
                    icon="school"
                    area="Pangandaran"
                />
                <CardTotalData
                    :data="banjar"
                    :isLoading="isLoading"
                    label="Sekolah"
                    icon="school"
                    area="Banjar"
                />
            </div>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed } from "vue";
// import CardTotalData from "../../components/Admin/Card/CardTotalData.vue";
import { CardTotalData, Card } from "../../components";
// const CardTotalData = () => import("@/components/Admin/Card/CardTotalData.vue");
import { useStepOnesComposables as stepOne } from "@/composables";
import { useAuthStore } from "@/store";

export default {
    setup() {
        const { countStepOnes, isLoading, getCountStepOnes } = stepOne();
        const auth = useAuthStore();
        const kuningan = ref(0);
        const banjar = ref(0);
        const pangandaran = ref(0);
        const ciamis = ref(0);
        const authUser = computed(() => auth.authUser);

        const fetchData = async () => {
            await getCountStepOnes();
            kuningan.value = countStepOnes.value.countKuningan;
            banjar.value = countStepOnes.value.countBanjar;
            pangandaran.value = countStepOnes.value.countPangandaran;
            ciamis.value = countStepOnes.value.countCiamis;
        };

        onMounted(() => {
            fetchData();
        });
        // console.log(countStepOnes);
        return {
            countStepOnes,
            isLoading,
            authUser,
            kuningan,
            banjar,
            pangandaran,
            ciamis,
        };
    },
    components: {
        CardTotalData,
        Card,
    },
};
</script>
