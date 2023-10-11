
<template>
    <div class="">
        <ModalLoading :isLoading="isLoading"></ModalLoading>
        <Modal @update:go-function="deleteData" label="Delete" />
        <form @submit.prevent="handleSubmit" class="mt-4 space-y-4">
            <div class="">
                <Select label="Dapil Category" text="Pilih Dapil Category" :data="initDapilC" v-model="form.dapilCategoryId"
                    :search="dapilCategory" @update:search="form.dapilCategoryId = $event"></Select>
                <!-- {{ dapilCategories }} -->
            </div>
            <div class="">
                <Select label="Provinsi" text="Pilih Provinsi" :data="initProvince" v-model="form.provinceId"
                    :search="provinceId" @update:search="form.provinceId = $event"></Select>
                <!-- {{ dapilCategories }} -->
            </div>
            <div class="">
                <Select label="Kota / Kabupaten" text="Pilih Kota" :data="initCity" v-model="form.CityId"
                    :search="form.cityId" @update:search="form.cityId = $event"></Select>
                <!-- {{ dapilCategories }} -->
            </div>
            <div class="">
                <SelectMultiple label="Kecamatan" text="Pilih Kota" :data="initDistrict" v-model="form.go_wil"
                    :search="initWil" @update:search="form.go_wil = $event"></SelectMultiple>

            </div>
            <div>
                <Button class="mt-7">Submit</Button>
            </div>
        </form>
    </div>
</template>
<script>
import { ref, onMounted, computed, watch } from 'vue';
import { onBeforeRouteLeave } from 'vue-router';
import { Select, Input, Button, ImageUpload, ModalLoading, Modal, SelectMultiple } from "@/components";
import { useDapilCategoryStore, useAlertStore } from '@/store'
import { useDapilComposables, useDapilWilComposables } from '@/composables'
import { useRoute, useRouter } from 'vue-router';
// import 'jquery';


export default {
    props: {
        id: null
    },
    setup(props) {
        const dapilStore = useDapilCategoryStore()
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const id = route.params.id
        // const { getDapilCategory, dapilCategories } = useDapilComposables()
        const { dapilWils, getDapilWils, showDapilWils, getDapilCategory, dapilCategories, getProvince, getCity, getDistrict } = useDapilWilComposables()
        // const id = ref('')
        const create = ref(true)
        const isLoading = ref(false)
        const dapilCategory = ref(0)
        const initDapilC = ref([])
        const initProvince = ref([])
        const initCity = ref([])
        const initDistrict = ref([])
        const selectedDis = ref([])
        const initWil = ref([])
        const go_wil = ref([])
        // const form = ref({
        //     dapilCategoryId: 0,
        //     provinceId: 0,
        //     cityId: 0,
        //     // go_wil: []
        // })
        let provinceId = ''
        const fetchDapilCategory = async () => {
            await getDapilCategory()
            initDapilC.value = dapilCategories.value
        }
        const fetchProvince = async () => {
            const data = await getProvince()
            // console.log(data)
            initProvince.value = data
        }
        const fetchCity = async (id) => {
            const data = await getCity(id)
            initCity.value = data
        }
        const fetchDistrict = async (id) => {
            const data = await getDistrict(id)
            // console
            initWil.value = initWil.value.map((item) => ({
                id: item.districts.id,
                name: item.districts.name
            }))
            console.log(initWil.value)
            initDistrict.value = data
        }

        const fetchEdit = async () => {
            await showDapilWils(route.params.id)
            if (dapilWils) {
                // console.log(route.params.id)
                const data = dapilWils.value.data
                const form = ref({
                    provinceId: data.provinceId
                })
                provinceId = form.value.provinceId
                console.log(provinceId)
                initWil.value = dapilWils.value.data.go_wil
                console.log(form.value)
                dapilCategory.value = dapilWils.value.data.dapilCategoryId
                // dapil.value = dapilWils.value.districtCategoryId
                // console.log(dapilCategories.value.data)
                create.value = false
            }
        }
        const deleteData = async () => {
            // console.log(data.value.id);
            await deleteDapilCategory(id);
            await router.push('/admin/dapil/dapil-category')
            alert.showAlert('Data berhasil dihapus')
        };

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (!create.value) {
                    console.log("edit");
                    await dapilStore.storeData(form.value, true, route.params.id);
                } else {
                    // console.log("tambah");
                    await dapilStore.storeData(form.value, false);
                }
                // route.push('/admin/dapil/dapil-category')
                isLoading.value = false
            } catch (e) {
                isLoading.value = false
                return
            }
        }

        watch(
            () => form.value.provinceId,
            (id) => {
                provinceId = ''
                fetchCity(id);
            }
        );
        watch(
            () => form.value.cityId,
            (id) => {
                fetchDistrict(id);
            }
        );
        // watch(form, (newForm) => {
        //     console.log()
        // })
        watch(form, (newForm) => {
            console.log(newForm);
        },
            { deep: true }
        );

        onMounted(async () => {
            fetchDapilCategory()
            fetchProvince()
            // fetchCity()
            // fetchDistrict()
            fetchEdit()
        })

        return {
            form,
            dapilCategories,
            isLoading,
            dapilStore,
            deleteData,
            handleSubmit,
            dapilCategory,
            initDapilC,
            initProvince,
            initCity,
            initWil,
            go_wil,
            provinceId,
            selectedDis,
            initDistrict,
            id
        }
    },
    components: {
        Select,
        // Select2,
        SelectMultiple,
        Input,
        Button,
        ImageUpload,
        ModalLoading,
        Modal
    },
}
</script>
