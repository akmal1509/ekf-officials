<template>
    <div>
        <p class="font-medium text-sm"> {{ label }}<span class="font-normal"> : {{ text }}</span></p>
    </div>
</template>
<script>
export default {
    props: {
        label: {
            type: String,
            default: ''
        },
        text: {
            type: [String, Number],
            default: ''
        }
    }
}
</script>
