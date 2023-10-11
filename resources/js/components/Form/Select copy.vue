<template>
    <div class="relative" ref="dropdownContainer">
        <div class="mb-3">
            <label for="" class="">{{ label }}</label>
        </div>
        <div @click="toggleDropdown"
            class="w-full text-left p-2 pl-4 border form-control text-gray-400 text-[14px] rounded focus:outline-none focus:ring focus:border-blue-300">
            <div class="flex justify-between items-center" :class="{ 'text-black': selectedItem }">
                <div v-if="depend">
                    <p v-if="data.length < 1">{{ depend }}</p>
                    <p v-else>{{ selectedItem || text }}</p>
                </div>
                <p v-else>{{ selectedItem || text }}</p>
                <i class="fas fa-caret-down text-gray-400"></i>
            </div>
        </div>
        <ul v-show="isDropdownOpen" class="absolute z-10 top-15 w-full border rounded bg-white shadow-lg">
            <li class="p-2">
                <!-- <input
                    ref="inputSelected"
                    v-model="searchQuery"
                    @input="filterOptions"
                    class="w-full p-2 border-b form-control focus-visible:border-rkYellow focus-visible:ring-rkYellow focus-visible:outline-rkYellow"
                    placeholder="Cari opsi..."
                /> -->
                <input ref="inputSelected" type="text" v-model="searchQuery" @input="$event.target.composing = false"
                    class="w-full p-2 border-b form-control focus-visible:border-rkYellow focus-visible:ring-rkYellow focus-visible:outline-rkYellow"
                    placeholder="Cari opsi..." autocomplete="off" />
            </li>
            <li v-for="(option, index) in filteredOptions" :key="option.id" @click="selectOption(option)"
                :class="{ 'bg-gray-200': selectedItem === option.name }" class="p-2 cursor-pointer hover:bg-gray-100">
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
        isLoading: {
            type: Boolean,
            default: true
        },
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
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            isDropdownOpen: false,
            selectedItem: "",
            searchQuery: "",
            select: "",
        };
    },
    watch: {
        searchQuery(newSearch, oldSearch) {
            console.log(newSearch)
        },
    },
    computed: {
        filteredOptions(props) {
            if (props.search) {
                // console.log(props.search);
                // console.log(this.data)
                this.select = this.data.find(
                    (item) => parseInt(item.id) === parseInt(props.search)
                );
                if (this.select) {
                    this.selectedItem = this.select.name;
                }
            }

            // console.log(this.select)
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
            this.selectedItem = option.name;
            this.$emit("update:search", parseInt(option.id));
            this.isDropdownOpen = false;
        },
        filterOptions() { },
        closeDropdownOnClickOutside(event) {
            if (!this.$refs.dropdownContainer.contains(event.target)) {
                this.isDropdownOpen = false;
            }
        },
    },
    mounted() {
        document.addEventListener("click", this.closeDropdownOnClickOutside);
        // if (this.search) {
        //     this.select = this.data.find((item) => item.id === this.search);
        //     console.log(this.select);
        //     this.selectedItem = this.select.name;
        // }
    },
    beforeUnmount() {
        document.removeEventListener("click", this.closeDropdownOnClickOutside);
    },
};
</script>
