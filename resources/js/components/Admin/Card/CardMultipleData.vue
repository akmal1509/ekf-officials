<template>
    <div>
        <p v-if="title" class="mb-3 text-lg font-semibold">
            Total Data {{ label }}
        </p>
        <Card>
            <div class="flex items-center">
                <div class="flex flex-grow">
                    <div class="flex flex-col">
                        <p class="text-sm">Total Data {{ label }}</p>
                        <p class="mt-2 font-bold">{{ data.total }}</p>
                    </div>
                </div>
                <div
                    class="bg-gd w-12 h-12 rounded-xl flex justify-center items-center"
                >
                    <i
                        class="fas fa-graduation-cap text-size-lg text-white"
                    ></i>
                </div>
            </div>
        </Card>
    </div>
</template>
<script>
import Card from "./Card.vue";
export default {
    name: "CardMultipleData",
    props: {
        data: {
            type: Object,
            default: [],
        },
        label: {
            type: String,
            default: "",
        },
        auth: {
            type: Array,
            default: [],
        },
        title: {
            type: Boolean,
            default: false,
        },
    },
    components: {
        Card,
    },
};
</script>
