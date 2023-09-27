<template>
    <div>
        <vue3-select
            v-model="selectedOption"
            :options="options"
            label="label"
            searchable
            class="form-control"
            placeholder="Pilih salah satu..."
        >
            <template v-slot:no-options="{ search, searching }">
                <template v-if="searching"> Tidak ada data </template>
                <em v-else style="opacity: 0.5"
                    >Start typing to search for a country.
                </em>
            </template>
        </vue3-select>
    </div>
</template>

<script>
import { ref } from "vue";
import "vue3-select/dist/vue3-select.css";
import Vue3Select from "vue3-select";

export default {
    components: {
        Vue3Select,
    },
    setup() {
        const selectedOption = ref(null);

        const options = [
            { value: "option1", label: "Option 1" },
            { value: "option2", label: "Option 2" },
            { value: "option3", label: "Option 3" },
        ];

        return {
            selectedOption,
            options,
        };
    },
};
</script>
