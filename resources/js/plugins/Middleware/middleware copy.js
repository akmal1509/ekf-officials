import { useAuthStore as auth, useStepOneStore } from '@/store'
import { useStepOnesComposables as stepOnes } from '@/composables'
import { ref } from 'vue';

export async function checkSurveySekolahOwnership(context, next) {
    // console.log(context.to.params)
    // const { showStepOne, getStepOneShow } = stepOnes()
    const stepOneStore = useStepOneStore();
    const id = context.to.params.id;
    const authStore = auth();
    try {
        await authStore.getMe();
        await stepOneStore.getStepOneShow(id)
        const user = await authStore.authUser;
        const stepOne = await stepOneStore.stepOneData
        if (user.admin != 1 && stepOne.userId !== user.id) {
            next('/admin/dashboard');
        } else {
            next();
        }
    } catch (e) {
        console.log(e)
    }
    // console.log(id)


}

export async function checkAuth(required) {
    const authStore = auth();
    try {
        await authStore.getMe();

        if ((required && authStore.authUser) || (!required && !authStore.authUser)) {
            console.log('halo')
            console.log(authStore.authUser)
            return true;
        } else {
            console.log('hali')
            console.log(required)
            return false;
        }
    } catch (error) {
        return false;
    }
}

export async function requireAuth(context, next) {
    const authStore = auth();
    const isAuthenticated = authStore.getMe();
    if (!isAuthenticated) {
        next('/mejakami');
    } else {
        next();
    }
}

export async function guestOnly(context, next) {
    const tokenStorage = localStorage.getItem('authToken')

    const authStore = auth();
    const isAuthenticated = authStore.getMe();
    if (!isAuthenticated) {
        next();
    } else {
        next("/admin/dashboard");
    }

}
// export async function guestOnly(context, next) {
//     const tokenStorage = localStorage.getItem('authToken')
//     if (!tokenStorage) {
//         next();
//     } else {
//         const authStore = auth();
//         const isAuthenticated = authStore.getMe();
//         if (!isAuthenticated) {
//             next();
//         } else {
//             next("/admin/dashboard");
//         }
//     }
// }
