import { defineAsyncComponent } from 'vue'
import { Button, ButtonCreate, Card, CardTotalData, CardMultipleData, Dropdown, DropdownList, DropdownSidebar, Sidebar, ShowingData, Navbar, BottomNav, MenuSidebar } from './Admin'
import { Input, Select, ImageUpload } from './Form'
import { ImageSkeleton } from './Skeleton'

// console.log(CardMultipleData)
// import CardTotalData from './Admin/Card/CardTotalData.vue'

const Paginate = defineAsyncComponent(() => import('./Paginate.vue'))
const Modal = defineAsyncComponent(() => import('./Modal.vue'))


export { Input, Button, Dropdown, Paginate, Sidebar, BottomNav, Navbar, CardMultipleData, CardTotalData, Card, ButtonCreate, ImageSkeleton, Select, ShowingData, Modal, DropdownList, DropdownSidebar, ImageUpload }
