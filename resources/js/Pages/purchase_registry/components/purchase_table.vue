<script setup>
// primeVUE components
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional

const props = defineProps({
    title: String,
    registries:{
        type: Array,
        required: true,
    },
});
console.log(props.registries);




</script>

<template>
    <DataTable :value="props.registries" tableStyle="min-width: 50rem">
            <Column field="id" header="ID"></Column>
            <Column field="concept" header="Concepto"></Column>
            <Column field="amount" header="Monto"></Column>
            <Column field="category.name" header="Categoria"></Column>
            <Column field="sub_category.name" header="Sub Categoria"></Column>
            <Column field="payment_method.method" header="Metodo de Pago"></Column>
    </DataTable>
</template>