<template>
    <div class="relative w-full h-full">
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg">
            <nav class="flex justify-around p-4 bottom-nav">
                <!-- Tambahkan tombol untuk setiap tautan di bottom navbar -->
                <router-link to="/admin/dashboard" :class="{ isActive: isLinkActive('/admin/dashboard') }">
                    <i class="fas fa-home"></i>
                    <span class="block text-xs">Dashboard</span>
                </router-link>

                <router-link to="/admin/survey-sekolah" :class="{ isActive: isLinkActive('/admin/survey-sekolah') }">
                    <i class="fas fa-graduation-cap"></i>
                    <span class="block text-xs">Sekolah</span>
                </router-link>

                <router-link to="/admin/canvas" :class="{ isActive: isLinkActive('/admin/canvas') }">
                    <i class="fas fa-spider"></i>
                    <span class="block text-xs">Canvas</span>
                </router-link>

                <a type="button" class="hover:!text-gray-500" @click="toggleSidebar">
                    <i class="fas fa-cog"></i>
                    <span class="block text-xs">Settings</span>
                </a>
            </nav>
        </div>
    </div>
</template>
<script>
import { useSidebarStore } from "@/store";

export default {
    methods: {
        toggleSidebar() {
            useSidebarStore().toggleSidebar();
        },
        isLinkActive(link) {
            // Periksa apakah link cocok dengan URL saat ini
            return this.$route.path === link;
        },
    },
};
</script>
