<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import purchase_table from "./components/purchase_table.vue";
import create_dialog from "./components/create_dialog.vue";
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';
import messageStore from "@/stores/messageStore";

import Button from 'primevue/button';



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

const create_dialog_visible = ref(false);

function open_create_dialog(){
  create_dialog_visible.value = true;
};

function show_info_message(data) {
  mensaje_registro.value = data.message;
  mensaje_registro_visible.value = true;
  severity.value = data.severity;
  messageStore.mostrarMensaje(mensaje_registro, severity.value);
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
          <Button label="Registrar compra" icon="pi pi-plus" @click="open_create_dialog" />
          <create_dialog
          :visible="create_dialog_visible"
          @update:visible="create_dialog_visible = $event"
          :categoryOptions = "props.categories"
          :payment_frequency = "props.payment_frequency"
          :paymentMethodOptions = "props.payment_method"
          :tdcOptions = "props.tdc"
          :spendTypeOptions ="props.spend_type"
          />
            <purchase_table 
            :registries="registries"
            :categories = "props.categories"
            :payment_frequency = "props.payment_frequency"
            :payment_method = "props.payment_method"
            :tdc = "props.tdc"
            :spend_type ="props.spend_type"
            @info_message="show_info_message"
            />
        </template>
    </AppLayout>
</template>