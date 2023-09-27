<template>
    <div class="">
        <button
            v-if="
                typeButton == 'button' ||
                typeButton == null ||
                typeButton == 'submit'
            "
            :type="typeButton ?? 'submit'"
            class=""
            :class="` ${width}`"
        >
            <div
                :class="`${Class}`"
                class="w-full flex justify-center items-center btn-akm"
            >
                <slot></slot>
            </div>
        </button>
        <a
            v-if="typeButton == 'link'"
            :href="href"
            class=""
            :class="` ${width}`"
        >
            <div
                :class="`${Class}`"
                class="w-full flex justify-center items-center btn-akm"
            >
                <slot></slot>
            </div>
        </a>
    </div>
</template>
<script>
export default {
    props: {
        typeButton: String,
        href: String,
        Class: {
            type: String,
            default: "bg-gradient",
        },
        width: {
            type: String,
            default: "w-full",
        },
    },
};
</script>
<style scope></style>
