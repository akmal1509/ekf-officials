<template>
    <div>
        <p class="text-lg font-semibold">Data Korcam</p>
        <div>
            <CardTotalData :data="total" :isLoading="isLoading" label="Dapil" icon="" />
        </div>
        <div>
            <input type="text" v-model="searchQuery.name" @input="$event.target.composing = false"
                class="form-control w-full mb-4" placeholder="Cari nama korcam atau kecamatan..." />
        </div>

        <Suspense>
            <template #default>
                <div v-if="!isLoading">
                    <div class="flex flex-col space-y-5">
                        <router-link :to="`/admin/penugasan-korcam/edit/${data.id}`" v-for="data in assignments.data">
                            <Card class="flex flex-row">
                                <div class="pl-2 space-y-3">
                                    <div>
                                        <p class="font-semibold">{{ data.users.name }}</p>
                                        <p class="">{{ data.dapilsName }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Kecamatan : </p>
                                        <p class="">{{ data.districts.name }}</p>
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
            <ButtonCreate link="/admin/penugasan-korcam/create" />
        </div>
    </div>
</template>
<script>
import { CardTotalData, Card, Paginate, ButtonCreate, CardSkeleton } from "@/components";
import { useAssignmentComposables } from '@/composables'
import { ref, onMounted, watchEffect } from 'vue'

export default {
    setup() {
        const { assignments, getAssignment } = useAssignmentComposables()
        const total = ref(0);
        const currentPage = ref(1);
        const pageSize = ref("10");
        const isLoading = ref(true);
        const searchQuery = ref({
            name: "",
        });
        const queryParams = ref("");
        const fetchData = async () => {
            isLoading.value = true
            await getAssignment(
                currentPage.value,
                pageSize.value,
                queryParams.value
            );
            // console.log(dapilCategories);
            total.value = await assignments.value.paginate.total;
            isLoading.value = false
        };
        watchEffect(() => {
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
            fetchData()
        })

        return {
            assignments,
            total,
            isLoading,
            searchQuery,
            currentPage,
            pageSize,
        }

    },
    components: {
        CardTotalData,
        Card,
        Paginate,
        ButtonCreate,
        CardSkeleton
    }
}
</script>
