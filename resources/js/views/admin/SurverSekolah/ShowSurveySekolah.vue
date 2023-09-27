<template>
    <div>
        <div class="flex">
            <router-link :to="`/admin/survey-sekolah/edit/${data.id}`"
                ><Button width="inline-block">Edit</Button>
            </router-link>
            <Modal @update:go-function="deleteStepOne" label="Delete" />
        </div>
        <div class="space-y-4 mt-4">
            <ShowingData>
                <template v-slot:label>Kepala Sekolah</template>
                <template v-slot:nama>{{ data.headmaster }}</template>
                <template v-slot:tel>{{ data.phoneHeadmaster }}</template>
            </ShowingData>
            <ShowingData>
                <template v-slot:label>Operator Sekolah</template>
                <template v-slot:nama>{{ data.schoolOperator }}</template>
                <template v-slot:tel>{{ data.phoneOperator }}</template>
            </ShowingData>
            <ShowingData>
                <template v-slot:label>Ketua Komite</template>
                <template v-slot:nama>{{ data.chairman }}</template>
                <template v-slot:tel>{{ data.phoneChairman }}</template>
            </ShowingData>
            <div class="space-y-4">
                <p class="text-sm font-semibold">
                    Foto bersama orang tua / wali murid
                </p>
                <img :src="data.image" class="max-w-full" alt="" />
            </div>
        </div>
    </div>
</template>
<script>
import { useRouter } from "vue-router";
import { useStepOneStore } from "@/store";
import { onBeforeUnmount } from "vue";
import { onBeforeRouteLeave } from "vue-router";
import { ShowingData, Button, Modal } from "@/components";
export default {
    setup() {
        const route = useRouter();
        const stepOneStore = useStepOneStore();
        const data = stepOneStore.stepOneData;
        const deleteStepOne = async () => {
            console.log(data.id);
            await stepOneStore.deleteStepOneData(data.id);
        };
        onBeforeRouteLeave(async () => {
            console.log("coba");
            await stepOneStore.removeState();
        });

        return {
            data,
            deleteStepOne,
        };
    },
    components: {
        ShowingData,
        Button,

        Modal,
    },
};
</script>
