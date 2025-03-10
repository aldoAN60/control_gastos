<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import purchase_table from "./components/purchase_table.vue";
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3'



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
  spend_type:{
    type:Array,
    required:true
  }
});
const registries = ref(props.purchase_registries); // Hacer la tabla reactiva

// Watch para actualizar la tabla cuando props.purchase_registries cambie
// watch(() => props.purchase_registries, (newRegistries) => {
//   console.log("✅ Se detectó cambio en purchase_registries");
//   registries.value = [...newRegistries]; // Forzar reactividad
// });


function reload_purchase_table() {
  router.reload({ 
    only: ["purchase_registries"],
    onSuccess: () => {
      console.log("🔄 Nuevos datos recibidos:", props.purchase_registries);
      registries.value = [...props.purchase_registries]; 
    }
  });
}


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
            :registries="registries"
            :categories = "props.categories"
            :payment_frequency = "props.payment_frequency"
            :payment_method = "props.payment_method"
            :tdc = "props.tdc"
            :spend_type ="props.spend_type"
            @reload_table="reload_purchase_table"
            />
        </template>
    </AppLayout>
</template>