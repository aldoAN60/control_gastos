<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import purchase_table from "./components/purchase_table.vue";
import { ref } from "vue";



// variables reactivas
const mensaje_registro = ref("");
const mensaje_registro_visible = ref(false);
const severity = ref("");

const props = defineProps({
  purchase_registries: {
    type: Array,
    required: true,
  },
});

</script>

<template>
    <AppLayout
        title="registro gastos"
        :mensaje_visible="mensaje_registro_visible"
        :mensaje="mensaje_registro"
        :severity="severity"
        >
        <template #header> Registro Gastos </template>
        <template #main_content>
            <purchase_table 
            :registries = "props.purchase_registries"
            
            ></purchase_table>
        </template>
    </AppLayout>
</template>