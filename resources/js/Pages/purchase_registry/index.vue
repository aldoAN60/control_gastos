<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import purchase_table from "./components/purchase_table.vue";
import create_dialog from "./components/create_dialog.vue";
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3';
import messageStore from "@/stores/messageStore";
import { computed } from "vue";
import { useToast } from "primevue/usetoast";


import Button from 'primevue/button';

//toast message
const toast = useToast();


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


// Función para convertir un solo objeto
function convertData(data) {
  return {
    id: Number(data.id),
    user_id: Number(data.user_id),
    tdc: data.tdc ? {
      id: Number(data.tdc.id),
      alias: String(data.tdc.alias),
      bank_id: Number(data.tdc.bank_id),
      bank_name: String(data.tdc.bank_name)
    } : null,
    concept: String(data.concept), 
    amount: parseFloat(data.amount),
    category: {
      id: Number(data.category.id),
      name: String(data.category.name), 
    },
    sub_category: {
      id: Number(data.sub_category.id),
      name: String(data.sub_category.name), 
    },
    payment_method: {
      id: Number(data.payment_method.id),
      method: String(data.payment_method.method), 
    },
    spend_type: String(data.spend_type), 
    purchase_registry_credit: data.purchase_registry_credit ? {
      id: Number(data.purchase_registry_credit.id),
      payment_frequency: {
        id: Number(data.purchase_registry_credit.payment_frequency.id),
        frequency: String(data.purchase_registry_credit.payment_frequency.frequency), 
      },
      qty_payment: Number(data.purchase_registry_credit.qty_payment),
      remain_payment: Number(data.purchase_registry_credit.remain_payment),
    } : null,
    purchase_registry_frequent: data.purchase_registry_frequent ? {
      id: Number(data.purchase_registry_frequent.id),
      payment_frequency: {
        id: Number(data.purchase_registry_frequent.payment_frequency.id),
        frequency: String(data.purchase_registry_frequent.payment_frequency.frequency), 
      },
      next_insert_date: String(data.purchase_registry_frequent.next_insert_date),
    } : null, 
    created_at: String(data.created_at),
    updated_at: String(data.updated_at),
  };
}

const registries = computed(() => {
  return props.purchase_registries.map(convertData);
});

const create_dialog_visible = ref(false);

function open_create_dialog(){
  create_dialog_visible.value = true;
};

  function show_info_message(data) {
    mensaje_registro.value = data.message;
    mensaje_registro_visible.value = true;
    severity.value = data.severity;
    messageStore.mostrarMensaje(mensaje_registro, severity.value);
    registries.value = [...props.purchase_registries]; // Forzar la actualización al crear una nueva referencia

    console.log(registries);
  }

  function show_toast(message_info) {
   
    generate_toast_message( message_info.severity, message_info.message);
  }
  // Función para generar el mensaje del Toast
  function generate_toast_message(severity = "info", detail, summary = "Notificación", life = 3000) {
    toast.add({ severity:severity, summary:summary, detail:detail, group:'tr', life:life });
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
          @info_message="show_info_message"
          />
            <purchase_table 
            :key="registries.length"
            :registries="registries"
            :categories = "props.categories"
            :payment_frequency = "props.payment_frequency"
            :payment_method = "props.payment_method"
            :tdc = "props.tdc"
            :spend_type ="props.spend_type"
            @update_success_message="show_toast"
            />
        </template>
    </AppLayout>
    <Toast group="tr" position="top-right" />
</template>