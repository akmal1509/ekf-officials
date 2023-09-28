<template>
    <nav class="flex items-center py-5 px-6 bg-white shadow-md min-h-[86px]">
        <div class="flex flex-grow justify-center">
            <div class="flex flex-col items-center ml-7">
                <Suspense>
                    <template #default>
                        <ImageSkeleton
                            v-if="!isLogoLoaded"
                            width="w-16"
                            height="h-full"
                        />
                        <div v-else>
                            <img :src="Logo" class="w-16" alt="" />
                        </div>
                    </template>
                </Suspense>

                <p class="text-rkRed text-[12px] font-semibold">
                    Relawan Kang Fuji
                </p>
            </div>
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
                        <ImageSkeleton
                            v-if="!isAvatarLoaded"
                            width="w-11"
                            height="h-full"
                        />
                        <div v-else>
                            <img
                                :src="Avatar"
                                class="w-11 h-full bg-rkRed rounded-lg"
                                alt=""
                            />
                        </div>
                    </template>
                </Suspense>
            </template>
            <template v-slot:body>
                <router-link to="/admin/profile">
                    <DropDownList label="Profile" />
                </router-link>
                <DropDownList
                    label="Logout"
                    @click="authStore.handleLogout()"
                />
            </template>
        </Dropdown>
    </nav>
</template>
<script>
import { Logo, Avatar } from "@/assets/index.js";
// import { Dropdown } from "../";
import Dropdown from "./Dropdown/Dropdown.vue";
import DropDownList from "./Dropdown/DropDownList.vue";
import { useAuthStore } from "@/store";
import ImageSkeleton from "../Skeleton/ImageSkeleton.vue";
import { ref } from "vue";
export default {
    setup() {
        const authStore = useAuthStore();
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
        return {
            authStore,
            isAvatarLoaded,
            isLogoLoaded,
        };
    },
    components: {
        Dropdown,
        DropDownList,
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
