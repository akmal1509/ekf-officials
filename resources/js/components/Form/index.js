import { defineAsyncComponent } from "vue";
const Input = defineAsyncComponent(() => import('./Input.vue'))
const Select = defineAsyncComponent(() => import('./Select.vue'))
const ImageUpload = defineAsyncComponent(() => import('./ImageUpload.vue'))
export { Input, Select, ImageUpload }
