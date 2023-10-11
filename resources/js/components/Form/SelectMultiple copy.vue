<template>
    <div class="relative" ref="dropdownContainer">
        <div class="mb-3">
            <label for="">{{ label }}</label>
        </div>
        <div @click="toggleDropdown"
            class="w-full text-left p-2 pl-4 border form-control text-gray-400 text-[14px] rounded focus:outline-none focus:ring focus:border-blue-300">
            <div class="flex justify-between items-center">
                <div v-if="depend">
                    <p v-if="data.length < 1">{{ depend }}</p>
                    <p v-else>
                        <span v-for="(selectedItem, index) in selectedItems" :key="index"
                            class="text-[#your-selected-color]">
                            {{ selectedItem }}
                            <button @click="removeSelectedItem(index)" class="text-red-500 ml-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    </p>
                </div>
                <p v-else>
                    <span v-for="(selectedItem, index) in selectedItems" :key="index" class="text-[#your-selected-color]">
                        {{ selectedItem }}
                        <button @click="removeSelectedItem(index)" class="text-red-500 ml-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                </p>
                <i class="fas fa-caret-down text-gray-400"></i>
            </div>
        </div>
        <ul v-show="isDropdownOpen" class="absolute z-10 top-15 w-full border rounded bg-white shadow-lg">
            <li class="p-2">
                <input ref="inputSelected" type="text" v-model="searchQuery" @input="$event.target.composing = false"
                    class="w-full p-2 border-b form-control focus-visible:border-rkYellow focus-visible:ring-rkYellow focus-visible:outline-rkYellow"
                    placeholder="Cari opsi..." autocomplete="off" />
            </li>
            <li v-for="(option, index) in filteredOptions" :key="option.id" @click="selectOption(option)"
                :class="{ 'bg-gray-200': isSelected(option.name) }" class="p-2 cursor-pointer hover:bg-gray-100">
                {{ option.name }}
            </li>
            <li v-if="filteredOptions.length === 0 && searchQuery" class="p-2 text-gray-500">
                Tidak ada hasil.
            </li>
            <li v-if="filteredOptions.length === 0 && !searchQuery" class="p-2 text-gray-500">
                Hubungi admin jika sekolah tidak ada
            </li>
        </ul>
    </div>
</template>

<script>
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
            default: false,
        },
        depend: {
            type: String,
            default: "",
        },
        search: {
            type: Number,
            default: 0,
        },
        selectedItems: {
            type: Array,
            default: () => [], // Awalnya kosong
        },
    },
    data() {
        return {
            isDropdownOpen: false,
            searchQuery: "",
        };
    },
    computed: {
        filteredOptions() {
            if (this.search) {
                const select = this.data.find((item) => parseInt(item.id) === parseInt(this.search));
                if (select) {
                    this.selectedItems.push(select.name);
                }
            }
            return this.data.filter((data) =>
                data.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
            if (this.isDropdownOpen) {
                this.$nextTick(() => {
                    this.$refs.inputSelected.focus();
                });
            }
        },
        selectOption(option) {
            this.selectedItems.push(option.name);
            // Tidak perlu menutup dropdown di sini
        },
        isSelected(optionName) {
            return this.selectedItems.includes(optionName);
        },
        removeSelectedItem(index) {
            this.selectedItems.splice(index, 1);
        },
    },
    mounted() {
        // Set selectedItems saat komponen dimount
        if (this.search) {
            const select = this.data.find((item) => parseInt(item.id) === parseInt(this.search));
            if (select) {
                this.selectedItems.push(select.name);
            }
        }
    },
};
</script>
