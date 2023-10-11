<template>
    <div>
        <el-select v-model="selectedItem" placeholder="Pilih item" filterable @visible-change="handleVisibleChange">
            <el-option v-for="item in filteredItems" :key="item.id" :label="item.name" :value="item.id"></el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedItem: null,
            items: [
                { id: 1, name: 'Item 1' },
                { id: 2, name: 'Item 2' },
                { id: 3, name: 'Item 3' },
                { id: 4, name: 'Item 4' },
                { id: 5, name: 'Item 5' },
                { id: 6, name: 'Item 6' },
                { id: 7, name: 'Item 7' },
                { id: 8, name: 'Item 8' },
                { id: 9, name: 'Item 9' },
                { id: 10, name: 'Item 10' }
            ],
            filteredItems: [],
            dropdownVisible: false,
        };
    },
    methods: {
        handleSearch(query) {
            // Lakukan pemfilteran data berdasarkan query di sini
            this.filteredItems = this.items.filter(item =>
                item.name.toLowerCase().includes(query.toLowerCase())
            );
        },
        handleVisibleChange(visible) {
            // Set dropdownVisible menjadi true saat dropdown terbuka
            this.dropdownVisible = visible;
        },
    },
};
</script>
