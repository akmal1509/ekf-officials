<template>
    <div>
        <div class="space-y-4">
            <Select label="Pilih Tipe" :data="selectData" text="Pilih Tipe" v-model="selectOption" :search="selectOption">
            </Select>
            <Select label="Pilih Category" :data="category" text="Pilih Category" v-model="selectCategory"
                :search="selectCategory" @update:search="selectCategory = $event">
            </Select>
            <!-- <Select v-if="selectCategory == '1'" label="Pilih Kota" :data="kota" text="Pilih Category"
                v-model="searchQuery.kotaId" :search="searchQuery.kotaId" @update:search="searchQuery.dapilId = $event">
            </Select> -->
            <Select v-if="selectCategory == '1'" label=" Pilih kota" :data="kota" text="Pilih Category"
                v-model="searchQuery.kotaId" :search="searchQuery.kotaId" @update:search="searchQuery.kotaId = $event">
            </Select>
            <Select v-if="selectCategory == '3' || selectCategory == '4'" label=" Pilih Dapil" :data="dapil"
                text="Pilih Category" v-model="searchQuery.dapilId" :search="searchQuery.dapilId"
                @update:search="searchQuery.dapilId = $event">
            </Select>
            <Select v-if="selectCategory == '4'" label="Kecamatan" :data="district" text="Pilih Category"
                v-model="searchQuery.districtId" :search="searchQuery.districtId"
                @update:search="searchQuery.districtId = $event">
            </Select>
            <!-- <Select v-if="selectCategory == '2'" label="Pilih Kota" :data="dapil" text="Pilih Kota"
                v-model="searchQuery.dapilId" :search="searchQuery.dapilId" @update:search="searchQuery.dapilId = $event">
            </Select> -->
        </div>
        <div>
            <VueApexCharts v-if="!isLoading" type="bar" height="400" :options="chartOptions" :series="series">
            </VueApexCharts>
            <div v-else class="flex items-center justify-center h-[400px]">
                <div class="flex flex-col items-center space-y-5">
                    <Spinner color="red" size="12"></Spinner>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Select } from '@/components'
import { Spinner } from "flowbite-vue";
import { ref, onMounted, watchEffect, watch } from 'vue'
import VueApexCharts from "vue3-apexcharts";
import { usePemetaanComposables, useAssignmentComposables } from '@/composables'

export default {
    setup() {
        const { pemetaan, getPemetaan } = usePemetaanComposables()
        const { dapil, getDapil, district, getDistrict } = useAssignmentComposables()
        const queryParams = ref("");
        const net = ref([])
        const net2 = ref([])
        const net3 = ref([])
        const search = ref('')
        const isLoading = ref(true)

        const selectKota = ref('167')
        const selectOption = ref(1)
        const selectCategory = ref('2')
        const searchQuery = ref({
            dapilId: '8',
            kotaId: '167',
            districtId: '2224'
        })
        const selectData = [
            { id: '1', name: 'Data Sekolah' },
            { id: '2', name: 'Data Canvas' },
        ]
        const category = [
            { id: '2', name: 'Kabupaten/kota' },
            { id: '1', name: 'Dapil' },
            { id: '3', name: 'Kecamatan' },
            { id: '4', name: 'Desa' },
        ]
        const kota = [
            { id: '168', name: 'Kuningan' },
            { id: '167', name: 'Ciamis' },
            { id: '178', name: 'Pangandaran' },
            { id: '187', name: 'Banjar' },
        ]

        const fetchData = async () => {
            isLoading.value = true
            await getDapil()
            await getDistrict(searchQuery.value.dapilId)
            await getPemetaan(queryParams.value)
            const test = pemetaan.value.data.data


            net.value.splice(0, net.value.length);
            net2.value.splice(0, net2.value.length);
            net3.value.splice(0, net3.value.length);
            test.forEach(item => {
                net.value.push(item.verif_step_one_count);
                net2.value.push(parseInt(item.step_one_count) - parseInt(item.verif_step_one_count));
                net3.value.push(item.name);
            });
            // console.log(net3.value)
            isLoading.value = false

        }

        // watch((searchQuery) => {
        //     console.log(searchQuery.value)
        // })
        watchEffect(() => {

            console.log(searchQuery.value.dapilId)
            if (selectCategory.value == 1) {
                search.value = searchQuery.value.kotaId
            }
            if (selectCategory.value == 3) {
                search.value = searchQuery.value.dapilId
            }
            if (selectCategory.value == 4) {
                search.value = searchQuery.value.districtId
            }
            const searchParams = [
                { key: "type", value: selectCategory.value },
                { key: "filterId", value: search.value },
            ];
            queryParams.value = searchParams
                .filter((param) => param.value !== "")
                .map((param) => `${param.key}=${param.value}`)
                .join("&");
            fetchData(queryParams.value);
        });
        onMounted(() => {
            fetchData()
        })

        const series = [
            {
                name: 'Verifikasi',
                data: net.value
            },
            {
                name: 'Belum Verifikasi',
                data: net2.value
            },
        ]
        const chartOptions = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: net3.value
            },
            fill: {
                opacity: 1
            },

            legend: {
                offsetY: 10
            }

            // tooltip: {
            //     y: {
            //         formatter: function (val) {
            //             return "$ " + val + " thousands"
            //         }
            //     }
            // }

        }

        return {
            selectData,
            selectOption,
            chartOptions,
            series,
            category,
            selectCategory,
            searchQuery,
            dapil,
            kota,
            selectKota,
            district,
            isLoading
        }
    },
    components: {
        Select,
        VueApexCharts,
        Spinner
    }
}
</script>
<style>
.apexcharts-legend {
    padding-top: 10px !important;
}
</style>
