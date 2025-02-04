<script setup>
// primeVUE components
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import formatDate from '@/helpers/commons';
import Message from 'primevue/message';
import Button from 'primevue/button';
// vue components
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import { router } from '@inertiajs/vue3'

import messageStore from "@/stores/messageStore";
import edit_dialog from './edit_dialog.vue';

const props = defineProps({
    title: String,
    registries:{
        type: Array,
        required: true,
    },
});

const formattedRegistries = ref(props.registries.map((registry) => ({
    ...registry,
    formattedDate: formatDate(registry.created_at), // Formatear la fecha
})));

const editingRows = ref([]);


const onRowEditSave = (event) => {
    let { newData, index } = event;

    // Guardamos una copia de los registros en edición
    console.log(editingRows);
    // Actualizamos el registro localmente antes de la solicitud
    formattedRegistries.value[index] = newData;

    router.put(route('pr.update'), newData, {
        onSuccess: (response) => {
            let res = response.props.flash.data;
            messageStore.mostrarMensaje(res.message, res.severity);

            // Limpiar errores si la solicitud fue exitosa
            validation_errors.value = {};

            // Cerrar la edición de la fila eliminándola del objeto
        },
        onError: (errors) => {
            // Guardamos los errores
            validation_errors.value = errors;

        }
    });
};




const validation_errors = ref({});

// edit dialog variables

const edit_dialog_visible = ref(false);
const selected_registry = ref({});

function open_edit_dialog(registry){

    selected_registry.value = {...registry};
    console.log(selected_registry.value);
    edit_dialog_visible.value = true;
}

function save_changes(update_changes){
    edit_dialog_visible.value = false;
    console.log("chidote".update_changes);
}


</script>

<template>

    <DataTable
        :value="formattedRegistries"
        dataKey="id"
        rowGroupMode="subheader"
        stripedRows
        tableStyle="min-width: 50rem"
    >
        <Column field="id" header="#"/>
        
        <Column field="concept" header="Concepto"/>
        <Column header="Categoria" field="category.name" />
        <Column field="amount" header="Monto"/>
        <Column field="payment_method.method" header="Método de pago"/>
        <Column field="formattedDate" header="Fecha de la compra"/>
        <Column field="sub_category.name" header="Sub categoría"/>
        <Column :exportable="false" style="min-width: 12rem">
            <template #body="{ data }">
                <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="open_edit_dialog(data)"/>
                <Button icon="pi pi-trash" outlined rounded severity="danger"/>
            </template>
        </Column>
    </DataTable>
    <edit_dialog 
        :visible="edit_dialog_visible"
        @update:visible="edit_dialog_visible = $event"
        :selected_registry="selected_registry"
        @save="save_changes"
    />

</template>
 <!-- * * * DATA QUE IRA EN LA OPCION MAS DETALLES * * * -->
        <!-- <Column header="Sub cateogoria" field="sub_category.name" />
        <Column field="tdc.alias" header="nombre metodo"></Column>
        <Column field="purchase_registry_credit" header="Compra realizada a credito"></Column>
        <Column field="purchase_registry_frequent" header="Compra frecuente"></Column> -->