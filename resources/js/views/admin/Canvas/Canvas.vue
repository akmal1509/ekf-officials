<template>
    <div>
        <p class="text-lg font-semibold">Data Canvas</p>
        <div>
            <CardTotalData :data="total" :isLoading="isLoading" label="Canvas" icon="" />
        </div>
        <div>
            <input type="text" v-model="searchQuery.name" @input="$event.target.composing = false"
                class="form-control w-full mb-4" placeholder="Cari nama pemilih" />
        </div>

        <Suspense>
            <template #default>
                <div v-if="!isLoading">
                    <div class="flex flex-col space-y-5">
                        <router-link :to="`/admin/canvas/${data.id}`" v-for="data in canvases.data">
                            <Card class="flex flex-row">
                                <div class="pl-2 ">
                                    <p class="font-bold">{{ data.name }}</p>
                                    <p v-if="data.parents">ref: {{ data.parents.name }}</p>
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
            <ButtonCreate link="/admin/canvas/create" />
        </div>
    </div>
</template>
<script>
import { CardTotalData, Card, Paginate, ButtonCreate, CardSkeleton } from "@/components";
import { useCanvasComposables } from '@/composables'
import { ref, onMounted, watchEffect } from 'vue'

export default {
    setup() {
        const { canvases, getCanvas } = useCanvasComposables()
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
            await getCanvas(
                currentPage.value,
                pageSize.value,
                queryParams.value
            );
            // console.log(dapilCategories);
            total.value = await canvases.value.paginate.total;
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
            canvases,
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
