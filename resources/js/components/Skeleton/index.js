import { defineAsyncComponent } from "vue"

const ImageSkeleton = defineAsyncComponent(() => import('./ImageSkeleton.vue'))


export { ImageSkeleton }
