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
                <div v-if="authUser.admin">
                    <router-link to="/admin/pemetaan" :class="{ isActive: isLinkActive('/admin/pemetaan') }">
                        <i class="fas fa-chart-bar"></i>
                        <span class="block text-xs">Pemetaan</span>
                    </router-link>
                </div>
                <a type="button" class="hover:!text-gray-500" @click="toggleSidebar">
                    <i class="fas fa-cog"></i>
                    <span class="block text-xs">Settings</span>
                </a>
            </nav>
        </div>
    </div>
</template>
<script>
import { useSidebarStore, useAuthStore } from "@/store";
import { computed } from "vue";

export default {
    setup() {
        const auth = useAuthStore();
        const authUser = computed(() => auth.authUser);

        return {
            authUser
        }
    },
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
