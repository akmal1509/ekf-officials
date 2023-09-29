<template>
    <Suspense>
        <template #default>
            <div class="" v-if="!isLoading">
                <div class="border-gray-200 border rounded-sm text-sm">
                    <div class="bg-white">
                        <p class="p-2 font-semibold">
                            <slot name="label"></slot>
                        </p>
                    </div>
                    <div class="p-2">
                        <p>Nama Lengkap : <slot name="nama"></slot>
                        </p>
                        <p>Nomor Telepon : <slot name="tel"></slot>
                        </p>
                        <p v-if="village">Desa: {{ village }}</p>
                    </div>
                </div>
            </div>
            <div v-else>
                <div role="status" class="max-w-sm animate-pulse">
                    <div class="border-gray-200 border rounded-sm text-sm">
                        <div class="bg-white">
                            <p class="p-2 font-semibold">
                                <slot name="label"></slot>
                            </p>
                        </div>
                        <div class="p-2">
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 w-40 max-w-full"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 w-40 max-w-full"></div>
                            <!-- <p>Nama Lengkap : <slot name="nama"></slot></p>
                            <p>Nomor Telepon : <slot name="tel"></slot></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Suspense>
</template>
<script setup>
defineProps({
    isLoading: {
        type: Boolean,
        default: true,
    },
    village: {
        type: String,
        default: ''
    }
});
</script>
