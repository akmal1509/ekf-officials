<template>
    <div>
        <MenuSideBar
            class="dropdown-head"
            dropdown
            text="Dapil"
            :link="data.link"
            :icon="data.icon"
            @click="toggleDropdown"
            :class="{ isOpen: isOpen }"
        />

        <transition name="dropdown" mode="out-in">
            <div
                class="akm-dropdown w-full bg-white text-gray-500"
                ref="dropdownRef"
                :style="{ height: dropdownHeight + 'px' }"
            >
                <div class="space-y-4 p-4 text-sm mt-2 flex flex-col">
                    <router-link
                        v-for="list in data.list"
                        :to="list.link"
                        :class="{ isActive: isLinkActive(`${list.link}`) }"
                    >
                        {{ list.text }}
                    </router-link>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
import { ref, onMounted, watch, nextTick } from "vue";
import MenuSideBar from "../MenuSideBar.vue";
import { useRouter } from "vue-router";

export default {
    props: {
        data: {
            type: Object,
            default: [],
        },
    },
    components: {
        MenuSideBar,
    },
    setup(props) {
        const isOpen = ref(false);
        const router = useRouter();
        const dropdownHeight = ref(0);
        const dropdownRef = ref(null);
        const isLinkActive = (link) => {
            // Periksa apakah link cocok dengan URL saat ini
            return router.currentRoute.value.path === link;
        };
        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;

            if (isOpen.value) {
                nextTick(() => {
                    const dropdownElement = dropdownRef.value;
                    if (dropdownElement) {
                        dropdownHeight.value = dropdownElement.scrollHeight;
                        console.log(dropdownHeight.value);
                    }
                });
            } else {
                dropdownHeight.value = 0;
                console.log(isOpen.value);
            }
        };
        return {
            toggleDropdown,
            dropdownHeight,
            dropdownRef,
            isOpen,
            isLinkActive,
        };
    },
};
</script>
<style scoped>
.akm-dropdown {
    transition: height 0.5s ease-in-out;
    overflow: hidden;
}
.dropdown-enter-active,
.dropdown-leave-active {
    transition: height 0.5s ease-in-out;
}
.dropdown-enter-to,
.dropdown-leave {
    height: 0;

    overflow: hidden;
}
.rotate-180 {
    transform: rotate(180deg);
}
</style>
