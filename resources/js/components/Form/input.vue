<template>
    <div>
        <label v-if="label" for="" class="">{{ label }}</label>
        <input
            :value="modelValue"
            :type="type"
            :placeholder="placeholder"
            class="mt-2 w-full form-control"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: "",
    },
    modelValue: {
        type: String,
        default: "",
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: "",
    },
});
</script>
