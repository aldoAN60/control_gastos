<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import purchase_table from "./components/purchase_table.vue";


const title = "hola desde promp";
</script>

<template>
    <AppLayout
        title="registro de compras"
        :mensaje_visible="mensaje_registro_visible"
        :mensaje="mensaje_registro"
        :severity="severity"
        >
        <template #header> Tarjetas de credito </template>
        <template #main_content >
            <h1>hola desde registro de compras</h1>
            <purchase_table :title = "title" ></purchase_table>
        </template>
    </AppLayout>
</template>