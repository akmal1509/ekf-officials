<template>
    <nav class="pagination" aria-label="Pagination">
        <ul class="flex">
            <li>
                <button
                    @click="firstPage"
                    :disabled="currentPage === 1"
                    class="px-3 py-1 bg-gray-200 rounded-md hover:enabled:bg-emerald-800 hover:enabled:text-white"
                >
                    {{ "<<" }}
                </button>
            </li>
            <li class="px-1">
                <button
                    @click="previousPage"
                    :disabled="currentPage === 1"
                    class="px-3 py-1 bg-gray-200 rounded-md hover:enabled:bg-emerald-800 hover:enabled:text-white"
                >
                    {{ "<" }}
                </button>
            </li>
            <li v-for="pageNumber in displayedPages" :key="pageNumber">
                <button
                    @click="goToPage(pageNumber)"
                    :class="{
                        'bg-emerald-800 text-white': currentPage === pageNumber,
                    }"
                    class="px-3 py-1 rounded-md hover:enabled:bg-emerald-800 hover:enabled:text-white"
                >
                    {{ pageNumber }}
                </button>
            </li>
            <li class="px-1">
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1 bg-gray-200 rounded-md hover:enabled:bg-emerald-800 hover:enabled:text-white"
                >
                    {{ ">" }}
                </button>
            </li>
            <li>
                <button
                    @click="lastPage"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1 bg-gray-200 rounded-md hover:enabled:bg-emerald-800 hover:enabled:text-white"
                >
                    {{ ">>" }}
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
import { ref, computed, watch } from "vue";

export default {
    props: {
        currentPage: Number,
        perPage: String,
        totalItems: Number,
    },
    setup(props, { emit }) {
        const currentPage = ref(props.currentPage);

        const totalPages = computed(() => {
            return Math.ceil(props.totalItems / parseInt(props.perPage));
        });

        const maxVisiblePages = 3; // Tampilkan 3 halaman per kali

        const displayedPages = computed(() => {
            const pages = [];
            const startPage = Math.max(currentPage.value - 1, 1);
            const endPage = Math.min(
                startPage + maxVisiblePages - 1,
                totalPages.value
            );

            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }

            return pages;
        });

        const firstPage = () => {
            if (currentPage.value !== 1) {
                currentPage.value = 1;
            }
        };

        const previousPage = () => {
            if (currentPage.value > 1) {
                currentPage.value--;
            }
        };

        const nextPage = () => {
            if (currentPage.value < totalPages.value) {
                currentPage.value++;
            }
        };

        const lastPage = () => {
            if (currentPage.value !== totalPages.value) {
                currentPage.value = totalPages.value;
            }
        };

        const goToPage = (pageNumber) => {
            if (pageNumber !== currentPage.value) {
                currentPage.value = pageNumber;
            }
        };

        watch(currentPage, (newPage) => {
            emit("update:currentPage", newPage);
        });

        return {
            currentPage,
            displayedPages,
            totalPages,
            firstPage,
            previousPage,
            nextPage,
            lastPage,
            goToPage,
        };
    },
};
</script>

<style scoped>
/* Gaya komponen Anda di sini */
</style>
