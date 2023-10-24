<template>
    <div>
        <p class="text-lg font-semibold">Data Survey Sekolah</p>
        <div>
            <CardTotalData :data="total" :isLoading="isLoading" label="Survey Sekolah" icon="school" />
        </div>
        <div>
            <input type="text" v-model="searchQuery.name" @input="$event.target.composing = false"
                class="form-control w-full mb-4" placeholder="Cari nama sekolah..." />
        </div>

        <Suspense>
            <template #default>
                <div v-if="!isLoading">
                    <div class="flex flex-col space-y-5">
                        <router-link v-for="data in  stepOnes.data " :to="`/admin/survey-sekolah/${data.id}`">
                            <Card class="flex flex-row">
                                <div class="basis-3/12">
                                    <img :src="data.image" class="object-cover w-full aspect-square rounded-md" alt="" />
                                </div>
                                <div class="pl-2 basis-9/12">
                                    <p v-if="data.schools" class="font-semibold">{{ data.schools.name }}</p>
                                    <p v-else class="font-semibold">
                                        {{ data.schoolName }}
                                    </p>
                                    <div class="text-sm pt-2" v-if="!authStore.authUser.admin">
                                        <p>Kelapa Sekolah</p>
                                        <p class="">{{ data.headmaster }}</p>
                                    </div>
                                    <div class="text-sm pt-2" v-else>
                                        <p>Korcam</p>
                                        <p class="">{{ data.users.name }}</p>
                                    </div>
                                </div>
                            </Card>
                        </router-link>
                    </div>
                </div>
                <div v-else>
                    <CardSkeleton />
                </div>
            </template>

        </Suspense>
        <div class="my-10">
            <Paginate :current-page="currentPage" :total-items="total" :per-page="pageSize"
                @update:current-page="currentPage = $event" />
        </div>
        <div>
            <ButtonCreate link="/admin/survey-sekolah/create" />
        </div>
    </div>
</template>
<script>
import { CardTotalData, Card, Paginate, ButtonCreate, CardSkeleton } from "@/components";
import { useStepOnesComposables as stepOne } from "@/composables";
import { useAuthStore } from '@/store'
import { ref, onMounted, watchEffect } from "vue";
export default {
    setup() {
        const { stepOnes, getStepOnes } = stepOne();
        const authStore = useAuthStore()
        const total = ref(0);
        const currentPage = ref(1);
        const pageSize = ref("5");
        const isLoading = ref(true);
        const searchQuery = ref({
            name: "",
        });
        const queryParams = ref("");
        const fetchData = async () => {
            isLoading.value = true
            await getStepOnes(
                currentPage.value,
                pageSize.value,
                queryParams.value
            );
            // console.log("h");
            total.value = await stepOnes.value.paginate.total;
            isLoading.value = false
        };

        watchEffect(() => {
            console.log(searchQuery.value.name)
            const searchParams = [
                { key: "name", value: searchQuery.value.name },
            ];
            queryParams.value = searchParams
                .filter((param) => param.value !== "")
                .map((param) => `search[${param.key}]=${param.value}`)
                .join("&");
            fetchData(currentPage.value, pageSize.value, queryParams.value);
        });
        onMounted(() => {
            fetchData();
        });
        // console.log(total);
        return {
            stepOnes,
            total,
            isLoading,
            searchQuery,
            currentPage,
            pageSize,
            authStore
        };
    },
    components: {
        CardTotalData,
        Card,
        Paginate,
        ButtonCreate,
        CardSkeleton
    },
};
</script>
