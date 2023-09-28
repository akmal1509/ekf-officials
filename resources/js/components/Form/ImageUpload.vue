<template>
    <div>
        <div
            @click="openFileInput"
            class="border border-dashed border-gray-300 p-4 mt-3 cursor-pointer"
        >
            <div
                v-if="!imagePreview && !defaultImage"
                class="flex justify-center"
            >
                <p class="text-gray-500">Klik di sini untuk memilih gambar</p>
            </div>
            <img
                v-else
                :src="imagePreview ?? defaultImage"
                alt="Pratinjau Gambar"
                class="w-full"
            />
            <!-- <p>{{ defaultImage }}</p> -->
        </div>
        <input
            ref="imageInput"
            type="file"
            accept="image/*"
            @change="handleFileChange"
            style="display: none"
        />
    </div>
</template>
<script>
import { ref, watch, onMounted } from "vue";

export default {
    props: {
        imageData: {
            type: String,
            default: "",
        },
        defaultImage: {
            type: String,
            default: "",
        },
    },
    setup(props, { emit }) {
        const imagePreview = ref("");
        const imageInput = ref("");
        const selectedImage = ref("");

        const handleFileChange = (event) => {
            selectedImage.value = event.target.files[0];
            imageInput.value = selectedImage.value;
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.value = e.target.result;
            };
            reader.readAsDataURL(selectedImage.value);
        };
        const openFileInput = () => {
            imageInput.value.click();
        };

        const imageChange = async () => {
            // console.log(props.imageData);
            imagePreview.value = props.imageData;
        };

        watch(
            () => props.imageData,
            (newImage) => {
                // Di sini Anda dapat memproses imageData yang baru
                console.log("New imageData:", newImage);
                if (newImage) {
                    // Jika imageData sudah tersedia, lakukan sesuatu
                    imagePreview.value = newImage;
                }
            }
        );
        watch(selectedImage, (newImageInput) => {
            console.log(newImageInput);
            emit("update:imageInput", newImageInput);
        });

        onMounted(() => {
            imageChange();
            console.log(props.imageData);
        });

        return {
            handleFileChange,
            openFileInput,
            imagePreview,
            imageInput,
        };
    },
};
</script>
