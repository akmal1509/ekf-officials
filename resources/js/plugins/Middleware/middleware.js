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

export async function checkAuth() {
    const authStore = auth();
    try {
        await authStore.getMe();

        if (authStore.authUser) {
            return true;
        } else {
            return false;
        }
    } catch (error) {
        return false;
    }
}

export async function requireAuth(context, next) {
    const isAuthenticated = await checkAuth(true);
    if (!isAuthenticated) {
        next('/mejakami');
    } else {
        next();
    }
}

export async function guestOnly(context, next) {
    const tokenStorage = localStorage.getItem('authToken')
    if (!tokenStorage) {
        next();
    } else {
        const isAuthenticated = await checkAuth();
        if (!isAuthenticated) {
            next();
        } else {
            next("/admin/dashboard");
        }
    }
}
