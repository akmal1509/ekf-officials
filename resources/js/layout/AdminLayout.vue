<template>
    <div>
        <transition name="fades">
            <div v-if="alertOpen" class="fixed w-full fades z-50 flex justify-end top-8 px-4">
                <Alert class="w-full flex justify-center shadow-lg !bg-red-700 text-white" type="success">
                    {{ message }}
                </Alert>
            </div>
        </transition>
        <Sidebar />
        <div v-if="isSidebarOpen" class="fixed top-0 left-0 w-full h-full bg-[#00000045] z-10"></div>
        <Navbar />

        <router-view class="px-6 pt-5 pb-12 mb-24 min-h-[500px]"></router-view>
        <BottomNav class="lg:hidden z-50" />
    </div>
</template>
<script>
import { computed, onMounted, ref, watch } from "vue";
import { Alert } from "flowbite-vue";
import { useAlertStore, useSidebarStore } from "@/store";
import { Navbar, BottomNav, Sidebar } from "../components";

export default {
    setup() {
        const isOpen = ref("");
        const showButton = () => {
            isOpen.value = !isOpen.value;
        };
        const useAlert = useAlertStore();
        const message = computed(() => useAlert.message);
        const alertOpen = computed(() => useAlert.alertOpen);
        isOpen.value = alertOpen.value;
        console.log(isOpen.value);
        console.log(alertOpen.value);
        const isSidebarOpen = computed(() => useSidebarStore().sidebarOpen);

        onMounted(async () => {
        });
        return {
            message,
            isOpen,
            alertOpen,
            isOpen,
            showButton,
            isSidebarOpen,
        };
    },
    components: {
        Navbar,
        BottomNav,
        Sidebar,
        Alert,
    },
};

</script>
<style scope>
/* Atur transisi untuk elemen dengan name "fade" */
.fades-enter-active,
.fades-leave-active {
    opacity: 0;
    transition: opacity 0.5s;
}

.fades-enter,
.fades-leave-to

/* .fade-leave-active below version 2.1.8 */
    {
    opacity: 0;
}

.fades-enter-to {
    opacity: 100;
}
</style>
