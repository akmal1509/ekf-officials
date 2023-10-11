<template>
    <div>
        <label v-if="label" for="" class="">{{ label }}</label>
        <input :required="required" :readonly="readOnly" :value="modelValue" :type="type" :placeholder="placeholder"
            autocomplete="off" class="mt-2 w-full form-control" :class="{
                '!bg-gray-200 focus:border-0 focus:ring-0 text-gray-400':
                    readOnly,
            }" @input="$emit('update:modelValue', $event.target.value)" />
    </div>
</template>

<script setup>
// throw new Error("asdasd");
// import { defineProps } from "vue";
defineProps({
    required: {
        type: Boolean,
        default: false
    },
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
    readOnly: {
        type: Boolean,
        default: false,
    },
});
</script>
