<template>
    <router-link :to="link">
        <div
            class="fixed bottom-24 right-6 flex justify-center items-center w-10 h-10 bg-gradient rounded-full text-white text-xl"
        >
            +
        </div>
    </router-link>
</template>
<script>
export default {
    props: {
        link: {
            type: String,
            default: "",
        },
    },
};
</script>
