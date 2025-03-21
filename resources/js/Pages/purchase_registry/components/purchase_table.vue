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
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

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
// emits
const emit = defineEmits(["update_success_message"]);


// Función para formatear los registros
function formatRegistries(registries) {
    return registries.map((registry) => ({
        ...registry,
        formattedDate: formatDate(registry.created_at), // Formatear la fecha
    }));
}
const formattedRegistries = ref(formatRegistries(props.registries));

// edit dialog variables

const edit_dialog_visible = ref(false);
const selected_registry = ref({});
const regitry_to_update = ref({});

function open_edit_dialog() {
    regitry_to_update.value = selected_registry.value;
    edit_dialog_visible.value = true;
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

/* actulizar y eliminar*/
    function  delete_registry(){
        console.log("se elimino");
    };


function update_success_message(success_info_message){
    emit('update_success_message', success_info_message);
}

</script>

<template>
<!--  -->
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
    v-if="edit_dialog_visible"
    :visible="edit_dialog_visible"
    @update:visible="edit_dialog_visible = $event"
    :selected_registry="regitry_to_update"
    :categoryOptions="categories"
    :paymentMethodOptions="payment_method"
    :payment_frequency="payment_frequency"
    :tdcOptions="tdc"
    :spendTypeOptions="spend_type"
    @update_success_message="update_success_message"
/>


</template>
