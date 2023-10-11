<!-- Sidebar.vue -->
<template>
    <div>
        <!-- Sidebar content -->
        <aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed z-40 top-0 left-0 h-full w-64 bg-white text-white transition-transform transform ease-in-out duration-300 px-5">
            <div class="flex justify-center py-5">
                <Suspense>
                    <template #default>
                        <ImageSkeleton v-if="!isLogoLoaded" width="w-20" height="h-full" />
                        <div v-else>
                            <img :src="Logo" class="w-20" alt="" />
                        </div>
                    </template>
                </Suspense>
            </div>
            <hr class="h-px mt-0 bg-transparent via-black/40 bg-gradient-to-r from-transparent to-transparent mb-5" />
            <div class="space-y-5">
                <div class="">
                    <MenuSideBar link="/admin/dashboard" text="Dashboard" icon="fas fa-home" />
                </div>
                <div class="">
                    <DropdownSidebar v-if="isAdmin" :data="dapilCategory"></DropdownSidebar>
                </div>
                <div class="">
                    <MenuSideBar v-if="isAdmin" link="/admin/penugasan-korcam" text="Penugasan Korcam"
                        icon="fas fa-hands-helping" />
                </div>
                <div class="">
                    <MenuSideBar v-if="isAdmin" link="/admin/pengguna" text="Pengguna" icon="fas fa-user" />
                </div>
                <div class="">
                    <MenuSideBar link="/admin/survey-sekolah" text="Sekolah" icon="fas fa-graduation-cap" />
                </div>
            </div>
        </aside>
    </div>
</template>

<script>
import { useSidebarStore } from "@/store";
import { Logo } from "@/assets/index.js";
import ImageSkeleton from "../Skeleton/ImageSkeleton.vue";
// import { DropdownSidebar } from "@/components";
import { DropdownSidebar } from "./Dropdown";
import MenuSideBar from "./MenuSideBar.vue";
import { useAuthStore } from "@/store";

import { ref, onMounted, watch, nextTick, computed } from "vue";

export default {
    setup() {
        const isLogoLoaded = ref(false);
        const isAdmin = computed(() => useAuthStore().authUser.admin);
        const LogoImage = new Image();
        LogoImage.src = Logo;
        LogoImage.onload = () => {
            isLogoLoaded.value = true;
        };

        return {
            isLogoLoaded,
            Logo,
            isAdmin,
        };
    },

    components: {
        ImageSkeleton,
        DropdownSidebar,
        MenuSideBar,
    },
    data() {
        return {
            dapilCategory: {
                head: "Dapil",
                link: "/admin/dapil",
                icon: "fas fa-globe-europe",
                list: [
                    {
                        link: "/admin/dapil/dapil-category",
                        text: "Dapil category",
                    },
                    {
                        link: "/admin/dapil/dapil-wilayah",
                        text: "Wilayah dapil",
                    },
                ],
            },
            assignment: {},
        };
    },
    computed: {
        isSidebarOpen() {
            return useSidebarStore().sidebarOpen;
        },
    },
    // methods: {

    // },
};
</script>
