<template>
    <div class="w-full">
        <Suspense>
            <template #default>
                <div v-if="!isLoading">
                    <p v-if="title" class="text-lg font-semibold">
                        Total Data {{ label }}
                    </p>
                    <Card class="my-4">
                        <div class="flex items-center">
                            <div class="flex flex-grow">
                                <div class="flex flex-col">
                                    <p class="text-sm">
                                        Total Data {{ label }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <p class="font-bold">{{ data }}</p>
                                        <p v-if="area" class="ml-3">
                                            {{ area }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gd w-12 h-12 rounded-xl flex justify-center items-center"
                            >
                                <i
                                    :class="iconClasses"
                                    class="text-size-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </Card>
                </div>
                <div v-else>
                    <div role="status" class="max-w-sm animate-pulse">
                        <div
                            v-if="title"
                            class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"
                        ></div>

                        <Card class="my-4">
                            <div class="flex items-center">
                                <div class="flex flex-grow">
                                    <div class="flex flex-col">
                                        <div
                                            class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 w-40 max-w-full"
                                        ></div>

                                        <div class="flex items-center mt-2">
                                            <div
                                                class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 w-12 max-w-full"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-gd w-12 h-12 rounded-xl flex justify-center items-center"
                                >
                                    <i
                                        :class="iconClasses"
                                        class="text-size-lg text-white"
                                    ></i>
                                </div>
                            </div>
                        </Card>
                    </div>
                </div>
            </template>
        </Suspense>
    </div>
</template>
<script setup>
import { Card } from ".";
import { defineProps, computed } from "vue";

const props = defineProps({
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
    isLoading: {
        type: Boolean,
        default: true,
    },
});

const iconClasses = computed(() => {
    const iconMappings = {
        school: "fas fa-graduation-cap",
        default: "fas fa-globe-europe",
    };
    return iconMappings[props.icon] ?? iconMappings["default"];
});
</script>
