import { defineAsyncComponent } from 'vue'
import { Button, ButtonCreate, Card, CardTotalData, CardMultipleData, Dropdown, DropdownList, DropdownSidebar, Sidebar, ShowingData, Navbar, BottomNav, MenuSidebar } from './Admin'
import { Input, Select, ImageUpload } from './Form'
import { ImageSkeleton } from './Skeleton'

// console.log(CardMultipleData)
// import CardTotalData from './Admin/Card/CardTotalData.vue'

const Paginate = defineAsyncComponent(() => import('./Paginate.vue'))
const Modal = defineAsyncComponent(() => import('./Modal.vue'))
const ModalLoading = defineAsyncComponent(() => import('./ModalLoading.vue'))
const CardSkeleton = defineAsyncComponent(() => import('./Skeleton/CardSkeleton.vue'))
const SelectMultiple = defineAsyncComponent(() => import('./Form/SelectMultiple.vue'))
const Select2 = defineAsyncComponent(() => import('./Form/Select2.vue'))
const ShowData = defineAsyncComponent(() => import('./ShowData.vue'))


export { Input, Button, Dropdown, Paginate, Sidebar, BottomNav, Navbar, CardMultipleData, CardTotalData, Card, ButtonCreate, ImageSkeleton, Select, ShowingData, Modal, DropdownList, DropdownSidebar, ImageUpload, CardSkeleton, ModalLoading, SelectMultiple, Select2, ShowData }
