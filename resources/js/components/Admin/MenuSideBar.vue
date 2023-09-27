<template>
    <div>
        <div v-if="!dropdown">
            <router-link
                :to="link"
                :class="{ isActive: isLinkActive(`${link}`) }"
                class="text-gray-500 flex items-center space-x-4 relative"
            >
                <div
                    class="w-9 h-9 flex justify-center items-center bg-icon rounded-md shadow-md"
                >
                    <i :class="icon" class="text-sm"></i>
                </div>
                <p class="font-normal text-sm">{{ text }}</p>
            </router-link>
        </div>
        <div v-else>
            <a
                href="javascript:;"
                :class="{ isActive: isParentActive(`${link}`) }"
            >
                <div
                    class="text-gray-500 flex justify-between items-center relative"
                >
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-9 h-9 flex bg-icon justify-center items-center rounded-md shadow-md"
                        >
                            <i :class="icon" class="text-sm"></i>
                        </div>
                        <p class="font-normal text-sm">{{ text }}</p>
                    </div>
                    <div class="chev-dropdown">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>
<script setup>
import { ref, computed } from "vue"; // Import ref from Vue
import { useRouter } from "vue-router";
const router = useRouter(); // Create a reference to the router object

const props = defineProps({
    link: {
        type: String,
        default: "/",
    },
    text: {
        type: String,
        default: "",
    },
    icon: {
        type: String,
        default: "",
    },
    dropdown: {
        type: Boolean,
        default: false,
    },
});
const isLinkActive = (link) => {
    // Periksa apakah link cocok dengan URL saat ini
    return router.currentRoute.value.path === link;
};
const isParentActive = (link) => {
    return router.currentRoute.value.matched.some((record) =>
        record.path.startsWith(link)
    );
};
</script>
