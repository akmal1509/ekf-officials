<template>
    <div class="relative" ref="dropdownContainer">
        <div class="mb-3">
            <label for="" class="">{{ label }}</label>
        </div>
        <div @click="toggleDropdown"
            class="w-full text-left p-2 pl-4 border form-control text-gray-400 text-[14px] rounded focus:outline-none focus:ring focus:border-blue-300">
            <div class="flex justify-between items-center">
                <div>
                    <div class="space-x-1 space-y-1">
                        <p class="bg-blue-500 p-2 text-white inline-block rounded-md"
                            v-for="(selectData, index) in selectedItems" :key="index">{{ selectData.name }}
                            <button type="button" @click="removeSelectedItem(index)" class="text-white  ml-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </p>
                    </div>

                </div>
                <i class="fas fa-caret-down text-gray-400"></i>
            </div>
        </div>
        <ul v-show="isDropdownOpen" class="absolute z-10  top-15 w-full border rounded bg-white shadow-lg">
            <li class="p-2">
                <input ref="inputSelected" type="text" v-model="searchQuery" @input="$event.target.composing = false"
                    class="w-full p-2 border-b form-control focus-visible:border-rkYellow focus-visible:ring-rkYellow focus-visible:outline-rkYellow"
                    placeholder="Cari opsi..." autocomplete="off" />
            </li>
            <li class="overflow-y-auto h-72">
                <ul>
                    <li v-for="(option, index) in filteredOptions" :key="option.id" @click="selectOption(option)"
                        :class="{ 'bg-blue-500 text-white': isSelected(option) }" class="p-2 cursor-pointer ">
                        {{ option.name }}
                    </li>
                    <li v-if="filteredOptions.length === 0 && searchQuery" class="p-2 text-gray-500">
                        Tidak ada hasil.
                    </li>
                    <li v-if="filteredOptions.length === 0 && !searchQuery" class="p-2 text-gray-500">
                        Hubungi admin jika sekolah tidak ada
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
import { ref, computed, onMounted, nextTick, watch, watchEffect } from 'vue';
export default {
    props: {
        label: {
            type: String,
            default: "",
        },
        text: {
            type: String,
            default: "",
        },
        data: {
            type: Array,
            default: () => [],
        },
        multiple: {
            type: Boolean,
            default: false
        },
        // data: null,
        depend: {
            type: String,
            default: "",
        },
        search: {
            type: Array,
            default: () => [],
        },
        // selectedItems: {
        //     type: Array,
        //     default: () => [], // Awalnya kosong
        // },
    },
    setup(props, { emit }) {
        const isDropdownOpen = ref(false)
        const selectedItems = ref([])
        const searchQuery = ref('')
        const inputSelected = ref(null);

        const filteredOptions = computed(() => {
            return props.data.filter((data) =>
                data.name.toLowerCase().includes(searchQuery.value.toLowerCase())
            );
        })
        const filter = () => {
            console.log(props.search)
            // console.log(selectedItems.value)
            if (props.search.length > 0) {
                console.log('jalan')
                props.search.forEach((searchItem) => {
                    const select = props.data.find((item) => parseInt(item.id) === parseInt(searchItem.id))
                    if (select) {
                        selectedItems.value.push(select);
                        console.log(selectedItems.value)
                    }
                })
            } else {
                selectedItems.value = []
            }
        }
        const selectOption = (option) => {
            console.log(selectedItems.value)
            // selectedItems.value.push(option.name);
            const index = selectedItems.value.findIndex(item => item.name === option.name);
            // console.log(selectedItems.value)


            if (index === -1) {
                // Elemen tidak ditemukan dalam array, tambahkan
                selectedItems.value.push(option);
            } else {
                // Elemen ditemukan dalam array, hapus
                selectedItems.value.splice(index, 1);
            }
        }
        const toggleDropdown = () => {
            isDropdownOpen.value = !isDropdownOpen.value;
            if (isDropdownOpen.value) {
                nextTick(() => {
                    inputSelected.value.focus();
                });
            }
        }
        const isSelected = (option) => {

            return selectedItems.value.some((item) => item.name === option.name);

        }
        const removeSelectedItem = (index) => {
            selectedItems.value.splice(index, 1);
            // console.log(selectedItems.value)
        };
        watch(() => props.search, (newSelectedItems) => {
            // selectedItems.value = newSelectedItems;
            console.log('wa')
            filter()
        });
        watch(() => selectedItems.value, (newSelect, oldSelect) => {
            const selectedIds = newSelect.map(item => item.id);
            console.log(selectedIds)
            emit("update:search", selectedIds);
        }, { deep: true });

        onMounted(() => {
            filter()
        })
        return {
            isDropdownOpen,
            selectedItems,
            inputSelected,
            toggleDropdown,
            selectOption,
            removeSelectedItem,
            searchQuery,
            isSelected,
            filteredOptions
        }
    },

    mounted() {
        document.addEventListener("click", this.closeDropdownOnClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.closeDropdownOnClickOutside);
    },

    methods: {
        closeDropdownOnClickOutside(event) {
            // Dapatkan referensi ke elemen dropdown Anda
            const dropdownContainer = this.$refs.dropdownContainer;

            // Dapatkan referensi ke elemen tombol "hapus" di dalam dropdown
            const removeButtons = dropdownContainer.querySelectorAll(".remove-button");

            // Periksa apakah klik dilakukan di dalam elemen dropdown atau pada tombol "hapus" di dalam dropdown
            if (
                dropdownContainer &&
                !dropdownContainer.contains(event.target) &&
                !Array.from(removeButtons).some(button => button.contains(event.target))
            ) {
                // Klik dilakukan di luar elemen dropdown dan bukan pada tombol "hapus", maka tutup dropdown
                this.isDropdownOpen = false;
            }
        },
    },
};
</script>
