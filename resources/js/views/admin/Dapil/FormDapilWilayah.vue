<template>
    <div>
        <div v-if="isLoading">
            <ModalLoading :isLoading="isLoading"></ModalLoading>
        </div>
        <div v-else>
            <Modal @update:go-function="deleteData" label="Delete" />
            <form @submit.prevent="handleSubmit" class="mt-4 space-y-4">
                <Select :data="dapilCategories" :search="form.dapilCategoryId"
                    @update:search="form.dapilCategoryId = $event" text="Pilih Dapil District"
                    label="District Category"></Select>
                <Select label="Provinsi" :data="province" :search="form.provinceId"
                    @update:search="form.provinceId = $event" text="Pilih Provinsi"></Select>
                <Select label="City" :data="city" :search="form.cityId" @update:search="form.cityId = $event"
                    text="Pilih Kota"></Select>
                <SelectMultiple label="Kecamatan" text="Pilih Kota" :data="district" v-model="form.go_wil"
                    :search="initDistrict" @update:search="form.go_wil = $event"></SelectMultiple>
                <Button class="mt-7">Submit</Button>
            </form>
        </div>
    </div>
</template>
<script>
import { Select, SelectMultiple, Button, ModalLoading, Modal } from '../../../components';
import { ref, onMounted, watch } from 'vue';
import { useDapilWilComposables as dapilWil } from '@/composables'
import { useDapilWilayahStore, useAlertStore } from '@/store'
import { useRoute, useRouter } from 'vue-router';
export default {
    setup(props) {
        const isLoading = ref(true)
        const alert = useAlertStore()
        const route = useRoute();
        const router = useRouter();
        const dapilWilStore = useDapilWilayahStore()
        const id = route.params.id
        const { dapilWils, getDapilWils, getDapilCategory, dapilCategories, showDapilWils, province, getProvince, getCity, city, district, getDistrict, deleteDapilWils } = dapilWil()
        const form = ref([])
        const initDistrict = ref([])
        const initDapilCategory = ref(0)

        const handleSubmit = async () => {
            try {
                isLoading.value = true
                if (id) {
                    console.log("edit");
                    await dapilWilStore.storeData(form.value, true, route.params.id);
                } else {
                    await dapilWilStore.storeData(form.value, false);
                }
                // route.push('/admin/dapil/dapil-category')
                isLoading.value = false
            } catch (e) {
                console.log(e)
                isLoading.value = false
                return
            }
        }
        const deleteData = async () => {
            await deleteDapilWils(id);
            await router.push('/admin/dapil/dapil-wilayah')
            alert.showAlert('Data berhasil dihapus')
        };

        const fetchEdit = async () => {

            await showDapilWils(id)
            form.value = dapilWils.value
            console.log(dapilWils.value)
            initDistrict.value = dapilWils.value.go_wil
            await fetchDapilCategory()
            await fetchProvince()
            await fetchCity(form.value.provinceId)
            await fetchDistrict(form.value.cityId)
            isLoading.value = false

        }

        const fetchData = async () => {
            await fetchDapilCategory()
            await fetchProvince()
            // console.log(id)
            isLoading.value = false
        }

        const fetchDapilCategory = async () => {
            await getDapilCategory()
        }

        const fetchProvince = async () => {
            await getProvince()
        }

        const fetchCity = async (id) => {
            await getCity(id)
        }
        const fetchDistrict = async (id) => {
            initDistrict.value = initDistrict.value.map((item) => ({
                id: item.districts.id,
                name: item.districts.name
            }))
            await getDistrict(id)
        }

        watch(() => form.value.provinceId, async (newProv, oldProv) => {
            if (oldProv !== undefined) {
                form.value.cityId = 0
            }
            await getCity(newProv)
        })
        watch(() => form.value.cityId, async (newProv, oldProv) => {
            if (oldProv !== undefined) {
                initDistrict.value = []
            }
            await getDistrict(newProv)
        })

        watch(form, (newForm) => {
            console.log(newForm);
        },
            { deep: true }
        );

        onMounted(() => {
            if (id) {
                fetchEdit()
            } else {
                fetchData()
            }

        })
        return {
            province,
            form,
            city,
            isLoading,
            district,
            dapilCategories,
            initDapilCategory,
            initDistrict,
            handleSubmit,
            deleteData
        }
    },
    components: {
        Select,
        SelectMultiple,
        Button,
        ModalLoading,
        Modal
    }
}
</script>
