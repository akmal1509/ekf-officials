import { defineAsyncComponent } from 'vue'
const Button = defineAsyncComponent(() => import('./Button.vue'))
const ButtonCreate = defineAsyncComponent(() => import('./ButtonCreate.vue'))

export { Button, ButtonCreate }
