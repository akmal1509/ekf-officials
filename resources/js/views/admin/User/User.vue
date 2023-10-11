<template>
    <div>
        <p class="text-lg font-semibold">Data User</p>
        <div>
            <CardTotalData :data="total" :isLoading="isLoading" label="User" icon="user" />
        </div>
        <div>
            <input type="text" v-model="searchQuery.name" @input="$event.target.composing = false"
                class="form-control w-full mb-4" placeholder="Cari nama korcam..." />
        </div>

        <Suspense>
            <template #default>
                <div v-if="!isLoading">
                    <div class="flex flex-col space-y-5">
                        <router-link :to="`/admin/pengguna/edit/${data.id}`" v-for="data in allUser.data">
                            <Card class="flex flex-row">
                                <div class="basis-3/12">
                                    <img :src="data.avatar || Avatar" class="object-cover w-full aspect-square rounded-md"
                                        alt="" />
                                </div>
                                <div class="pl-2 basis-9/12">
                                    <p class="font-semibold">{{ data.name }}</p>
                                    <div v-if="data.assignment.length > 0">
                                        <div class="text-sm pt-2">
                                            <p>Kecamatan</p>
                                            <p class="">{{ data.assignment[0].district.name }}</p>
                                            <p>Total data : {{ data.totalSurvey }}</p>
                                        </div>
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
            <ButtonCreate link="/admin/pengguna/create" />
        </div>
    </div>
</template>
<script>
import { CardTotalData, Card, Paginate, ButtonCreate, CardSkeleton } from "@/components";
import { useAuthStore } from "@/store"
import { useAuthComposables } from "@/composables"
import { ref, onMounted, watchEffect } from 'vue'
import { Avatar } from "@/assets/index.js";
export default {
    setup() {
        const authStore = useAuthStore()
        const { getAllUser, allUser } = useAuthComposables();
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
            await getAllUser(
                currentPage.value,
                pageSize.value,
                queryParams.value
            );
            // console.log("h");
            total.value = await allUser.value.paginate.total;
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
            fetchData()
        })

        return {
            allUser,
            total,
            isLoading,
            searchQuery,
            currentPage,
            pageSize,
            Avatar
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
