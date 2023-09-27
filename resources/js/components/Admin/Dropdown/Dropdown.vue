<template>
    <div class="relative" @click="toggleDropdown" ref="dropdownWrapper">
        <slot name="button"></slot>

        <div
            v-if="isOpen"
            class="absolute z-10 mt-2 w-44 origin-top-right right-0 bg-white border rounded-md shadow-lg"
            ref="dropdownElement"
        >
            <div class="divide-y divide-gray-100 py-1">
                <slot name="body"></slot>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watchEffect } from "vue";
import { createPopper } from "@popperjs/core";

export default {
    setup() {
        const isOpen = ref(false);
        const selectedOption = ref("Pilih Opsi");
        const options = ["Opsi 1", "Opsi 2", "Opsi 3"];

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };

        const selectOption = (option) => {
            selectedOption.value = option;
            isOpen.value = false;

            // Tutup dropdown setelah memilih
            if (popperInstance.value) {
                popperInstance.value.destroy();
            }
        };

        // Buat instance Popper.js
        const dropdownWrapper = ref(null);
        const dropdownElement = ref(null);
        let popperInstance = ref(null);

        const createPopperInstance = () => {
            if (popperInstance.value) {
                popperInstance.value.destroy();
            }

            popperInstance.value = createPopper(
                dropdownWrapper.value,
                dropdownElement.value,
                {
                    placement: "bottom-start",
                }
            );
        };

        // Fungsi untuk menutup dropdown saat mengklik di luar area
        const closeDropdownOnClickOutside = (event) => {
            if (!dropdownWrapper.value.contains(event.target)) {
                isOpen.value = false;
            }
        };

        // Tambahkan event listener saat komponen dimuat
        onMounted(() => {
            createPopperInstance();
            watchEffect(() => {
                if (isOpen.value) {
                    document.addEventListener(
                        "click",
                        closeDropdownOnClickOutside
                    );
                } else {
                    document.removeEventListener(
                        "click",
                        closeDropdownOnClickOutside
                    );
                }
            });
        });

        return {
            isOpen,
            selectedOption,
            options,
            toggleDropdown,
            selectOption,
            dropdownWrapper,
            dropdownElement,
            createPopperInstance,
        };
    },
};
</script>

<style scoped>
/* Gaya tampilan dropdown dan tombol */
</style>
