<script setup>
// primeVUE components
import DataTable from 'primevue/datatable';
import ContextMenu from 'primevue/contextmenu';
import Column from 'primevue/column';
import formatDate from '@/helpers/commons';
import Button from 'primevue/button';
// vue components
import { ref } from 'vue';
import messageStore from "@/stores/messageStore";
import edit_dialog from './edit_dialog.vue';

const props = defineProps({
    title: String,
    registries:{
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
    spend_type: {
        type: Array,
        required: true,
    }
});


const formattedRegistries = ref(props.registries.map((registry) => ({
    ...registry,
    formattedDate: formatDate(registry.created_at), // Formatear la fecha
})));

// edit dialog variables

const edit_dialog_visible = ref(false);
const selected_registry = ref({});
const registry_to_update = ref({});

function open_edit_dialog() {
    registry_to_update.value = selected_registry.value;
        
    
    edit_dialog_visible.value = true;
}

function  delete_registry(){
   console.log("se elimino");
};


function save_changes(update_changes){
    edit_dialog_visible.value = false;
}
const cm = ref();
const menuModel = ref([
    { label: 'Mas detalles', icon: 'pi pi-fw pi-search', command: () => open_edit_dialog() },
    {label: 'Eliminar', icon: 'pi pi-fw pi-times', command: () => delete_registry()}
]);

const onRowContextMenu = (event) => {
    if (!event.data) {
        return;
    }
    
    selected_registry.value = event.data;
    cm.value.show(event.originalEvent);
};



</script>

<template>

    <ContextMenu ref="cm" :model="menuModel" @hide="selected_registry = null" />
    <DataTable
        :value="formattedRegistries"
        dataKey="id"
        rowGroupMode="subheader"
        stripedRows
        tableStyle="min-width: 50rem"
        contextMenu
        v-model:contextMenuSelection="selected_registry"
        @rowContextmenu="onRowContextMenu"
    >
        <Column field="id" header="#"/>
        
        <Column field="concept" header="Concepto"/>
        <Column header="Categoria" field="category.name" />
        <Column field="amount" header="Monto"/>
        <Column field="payment_method.method" header="Método de pago"/>
        <Column field="formattedDate" header="Fecha de la compra"/>
        <Column field="sub_category.name" header="Sub categoría"/>
    </DataTable>
    <edit_dialog 
        :visible="edit_dialog_visible"
        @update:visible="edit_dialog_visible = $event"
        :selected_registry="registry_to_update"
        :categoryOptions = "categories"
        :paymentMethodOptions="payment_method"
        :tdcOptions="tdc"
        :spendTypeOptions="spend_type"
        @save="save_changes"
    />
</template>
