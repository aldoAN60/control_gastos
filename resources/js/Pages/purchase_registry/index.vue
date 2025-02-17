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
  categories: {
    type: Array,
    required: true,
  },
  payment_frequency: {
    type: Array,
    required: true,
  },
  payment_method: {
    type: Array,
    required: true,
  },
  tdc: {
    type: Array,
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
            :categories = "props.categories"
            :payment_frequency = "props.payment_frequency"
            :payment_method = "props.payment_method"
            :tdc = "props.tdc"
            
            ></purchase_table>
        </template>
    </AppLayout>
</template>