<template>
    <div class="relative" ref="dropdownContainer">
        <div class="mb-3">
            <label for="" class="">{{ label }}</label>
        </div>
        <button
            @click="toggleDropdown"
            class="w-full text-left p-2 pl-4 border form-control text-gray-400 text-[14px] rounded focus:outline-none focus:ring focus:border-blue-300"
        >
            <div class="flex justify-between items-center">
                {{ selectedItem || text }}
                <i class="fas fa-caret-down"></i>
            </div>
        </button>
        <ul
            v-show="isDropdownOpen"
            class="relative w-full border rounded bg-white shadow-lg"
        >
            <li class="p-2">
                <input
                    ref="inputInLi"
                    v-model="searchQuery"
                    @input="filterOptions"
                    class="w-full p-2 border-b form-control focus-visible:border-rkYellow focus-visible:ring-rkYellow focus-visible:outline-rkYellow"
                    placeholder="Cari opsi..."
                />
            </li>
            <li
                v-for="(option, index) in filteredOptions"
                :key="index"
                @click="selectOption(option)"
                :class="{ 'bg-gray-200': selectedItem === option }"
                class="p-2 cursor-pointer hover:bg-gray-100"
            >
                {{ option }}
            </li>
            <li
                v-if="filteredOptions.length === 0 && searchQuery"
                class="p-2 text-gray-500"
            >
                Tidak ada hasil.
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
    },
    data() {
        return {
            isDropdownOpen: false,
            selectedItem: "",
            options: ["Pilihan 1", "Pilihan 2", "Pilihan 3"],
            searchQuery: "",
        };
    },
    computed: {
        filteredOptions() {
            return this.options.filter((option) =>
                option.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
            if (this.isDropdownOpen) {
                this.$nextTick(() => {
                    this.$refs.inputInLi.focus();
                });
            }
        },
        selectOption(option) {
            this.selectedItem = option;
            this.isDropdownOpen = false;
        },
        filterOptions() {},
        closeDropdownOnClickOutside(event) {
            if (!this.$refs.dropdownContainer.contains(event.target)) {
                this.isDropdownOpen = false;
            }
        },
    },
    mounted() {
        document.addEventListener("click", this.closeDropdownOnClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.closeDropdownOnClickOutside);
    },
};
</script>
