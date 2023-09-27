<template>
    <div class="text-sm pl-3 py-3">
        {{ label }}
    </div>
</template>
<script setup>
defineProps({
    label: {
        type: String,
        default: "",
    },
});
</script>
