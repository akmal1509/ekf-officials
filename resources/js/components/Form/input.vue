<template>
    <div>
        <label v-if="label" for="" class="">{{ label }}</label>
        <input
            :value="modelValue"
            :type="type"
            :placeholder="placeholder"
            autocomplete="off"
            class="mt-2 w-full form-control"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </div>
</template>

<script setup>
// throw new Error("asdasd");
// import { defineProps } from "vue";
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
