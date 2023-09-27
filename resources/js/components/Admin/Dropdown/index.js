import { defineAsyncComponent } from 'vue'
const Dropdown = defineAsyncComponent(() => import('./Dropdown.vue'))
const DropdownList = defineAsyncComponent(() => import('./DropdownList.vue'))
const DropdownSidebar = defineAsyncComponent(() => import('./DropdownSidebar.vue'))

export { Dropdown, DropdownList, DropdownSidebar }
