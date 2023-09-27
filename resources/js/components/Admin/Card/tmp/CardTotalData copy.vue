<template>
    <div class="w-full">
        <p v-if="title" class="text-lg font-semibold">Total Data {{ label }}</p>
        <Card class="my-4">
            <div class="flex items-center">
                <div class="flex flex-grow">
                    <div class="flex flex-col">
                        <p class="text-sm">Total Data {{ label }}</p>
                        <div class="flex items-center mt-2">
                            <p class="font-bold">{{ data }}</p>
                            <p v-if="area" class="ml-3">{{ area }}</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gd w-12 h-12 rounded-xl flex justify-center items-center"
                >
                    <i :class="iconClasses" class="text-size-lg text-white"></i>
                </div>
            </div>
        </Card>
    </div>
</template>
<script>
import Card from "./Card.vue";
export default {
    name: "CardTotalData",
    props: {
        data: {
            type: Number,
            default: 0,
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
        icon: {
            type: String,
            default: "",
        },
        area: {
            type: String,
            default: "",
        },
    },
    components: {
        Card,
    },
    computed: {
        iconClasses() {
            const iconMappings = {
                school: "fas fa-graduation-cap",
                default: "fas fa-globe-europe",
            };
            return iconMappings[this.icon] ?? iconMappings["default"];
        },
    },
};
</script>
