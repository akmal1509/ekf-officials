<template>
    <div class="fixed inset-0 flex items-center justify-center z-50" v-if="isLoading">
        <div class="modal-overlay fixed inset-0 bg-black opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <!-- Modal content -->
            <div class="modal-content py-4 text-left px-6">


                <!-- Modal body -->
                <div class="modal-body flex justify-center">
                    <!-- Isi konten modal di sini -->
                    <div class="flex flex-col items-center space-y-5">
                        <Spinner color="red" size="12"></Spinner>
                        <p>Tunggu sebentar ya...</p>
                    </div>
                </div>

                <!-- Modal footer -->

            </div>
        </div>
    </div>
</template>

<script>
import { Button } from ".";
import { Spinner } from "flowbite-vue";
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
        isLoading: {
            type: Boolean,
            default: false
        }
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
        Spinner
    },
};
</script>

<style scoped>
/* Gaya CSS sesuai kebutuhan Anda */
</style>
