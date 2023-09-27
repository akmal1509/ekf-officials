import { defineAsyncComponent } from 'vue'
import { Card, CardTotalData, CardMultipleData } from './Card'
import { Dropdown, DropdownList, DropdownSidebar } from './Dropdown'
import { Button, ButtonCreate } from './Button'
const BottomNav = defineAsyncComponent(() => import('./BottomNav.vue'))
const Sidebar = defineAsyncComponent(() => import('./Sidebar.vue'))
const Navbar = defineAsyncComponent(() => import('./Navbar.vue'))
const ShowingData = defineAsyncComponent(() => import('./ShowingData.vue'))
const MenuSidebar = defineAsyncComponent(() => import('./MenuSidebar.vue'))

// import CardTotalData from './Card/CardTotalData.vue'


export { Sidebar, Navbar, CardTotalData, CardMultipleData, Card, Dropdown, BottomNav, ButtonCreate, Button, ShowingData, DropdownList, DropdownSidebar, MenuSidebar }
