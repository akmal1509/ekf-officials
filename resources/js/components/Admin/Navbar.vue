<template>
    <nav class="flex items-center py-5 px-6 bg-white shadow-md min-h-[86px]">
        <div class="flex flex-grow justify-center">
            <router-link to="/admin/dashboard">
                <div class="flex flex-col items-center ml-7">
                    <Suspense>
                        <template #default>
                            <ImageSkeleton v-if="!isLogoLoaded" width="w-16" height="h-full" />
                            <div v-else>
                                <img :src="Logo" class="w-16" alt="" />
                            </div>
                        </template>
                    </Suspense>

                    <p class="text-rkRed text-[12px] font-semibold">
                        Relawan Kang Fuji
                    </p>
                </div>
            </router-link>
        </div>
        <Dropdown>
            <template v-slot:button>
                <!-- <img
                    :src="Avatar"
                    class="w-11 h-full bg-rkRed rounded-lg"
                    alt=""
                /> -->
                <Suspense>
                    <template #default>
                        <ImageSkeleton v-if="!isAvatarLoaded" width="w-11" height="h-full" />
                        <div v-else class="w-11 h-11">
                            <img :src="imageAvatar ?? Avatar" class="w-11 h-full bg-rkRed rounded-lg object-cover" alt="" />
                        </div>
                    </template>
                </Suspense>
            </template>
            <template v-slot:body>
                <router-link to="/admin/profile">
                    <DropdownList label="Profile" />
                </router-link>
                <DropdownList label="Logout" @click="authStore.handleLogout()" />
            </template>
        </Dropdown>
    </nav>
</template>
<script>
import { Logo, Avatar } from "@/assets/index.js";
// import { Dropdown } from "../";
// import Dropdown from "./Dropdown/Dropdown.vue";
// import DropdownList from "./Dropdown/DropdownList.vue";
import { Dropdown, DropdownList } from "./Dropdown";
import { useAuthStore } from "@/store";
import ImageSkeleton from "../Skeleton/ImageSkeleton.vue";
import { ref, computed, onMounted } from "vue";
export default {
    setup() {
        const authStore = useAuthStore();
        const imageAvatar = computed(() => authStore.authUser.avatar)
        // const imageAvatar = ref('');
        // const fetchData = async()=>{
        //     await authStore.authUser
        // }
        const isAvatarLoaded = ref(false);
        const isLogoLoaded = ref(false);
        const LogoImage = new Image();
        const AvatarImage = new Image();
        LogoImage.src = Logo;
        LogoImage.onload = () => {
            isLogoLoaded.value = true;
        };
        AvatarImage.src = Avatar;
        AvatarImage.onload = () => {
            isAvatarLoaded.value = true;
        };
        onMounted(() => {
            // console.log(imageAvatar)
        })
        return {
            authStore,
            isAvatarLoaded,
            isLogoLoaded,
            imageAvatar
        };
    },
    components: {
        Dropdown,
        DropdownList,
        ImageSkeleton,
    },
    data() {
        return {
            Logo,
            Avatar,
        };
    },
};
</script>
