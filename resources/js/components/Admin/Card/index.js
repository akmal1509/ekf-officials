import { defineAsyncComponent } from 'vue'
const Card = defineAsyncComponent(() => import('./Card.vue'))
const CardTotalData = defineAsyncComponent(() => import('./CardTotalData.vue'))
const CardMultipleData = defineAsyncComponent(() => import('./CardMultipleData.vue'))

// import CardTotalData from './CardTotalData.vue'
// const CardMultipleData = () => import('./CardMultipleData.vue')

export { Card, CardTotalData, CardMultipleData }
