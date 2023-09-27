<template>
    <Button @click="toggleModal" width="inline-block ml-3" Class="bg-b-g">{{
        label
    }}</Button>

    <div
        class="fixed inset-0 flex items-center justify-center z-50"
        v-if="isOpen"
    >
        <div class="modal-overlay fixed inset-0 bg-black opacity-50"></div>

        <div
            class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto"
        >
            <!-- Modal content -->
            <div class="modal-content py-4 text-left px-6">
                <!-- Modal header -->
                <!-- <div class="modal-header flex justify-between">
                    <h3 class="text-2xl font-semibold">Modal Title</h3>
                    <button
                        class="modal-close px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300"
                        @click="toggleModal"
                    >
                        X
                    </button>
                </div> -->

                <!-- Modal body -->
                <div class="modal-body mt-4">
                    <!-- Isi konten modal di sini -->
                    <p>{{ textBody }}</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer mt-4 flex justify-end">
                    <Button
                        width="inline-block"
                        Class="bg-red-600"
                        @click="toggleModal"
                        >Tutup</Button
                    >
                    <Button
                        @click="customFunction"
                        width="inline-block"
                        class="ml-3"
                        >Iya</Button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Button } from ".";
export default {
    props: {
        label: {
            type: String,
            default: "Button",
        },
        type: {
            type: String,
            default: "delete",
        },
    },
    computed: {
        textBody() {
            if (this.type === "delete") {
                return "Apakah Kamu Yakin ingin Hapus data?";
            }
        },
    },
    // mounted: {},
    methods: {
        customFunction() {
            this.$emit("update:goFunction");
        },
        closeModal() {
            this.$emit("close");
        },
        toggleModal() {
            this.isOpen = !this.isOpen;
        },
    },
    data() {
        return {
            isOpen: false,
        };
    },
    components: {
        Button,
    },
};
</script>

<style scoped>
/* Gaya CSS sesuai kebutuhan Anda */
</style>
