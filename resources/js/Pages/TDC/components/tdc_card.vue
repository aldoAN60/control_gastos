<script setup>

import Card from 'primevue/card';
import { computed } from 'vue';
import Button from 'primevue/button';
const props = defineProps({
    id: Number,
    nombre: String,
    alias: String,
    limite_credito: String || null,
    fecha_corte: String,
    fecha_pago: String
});

const limite_credito_format = computed(() => {
    if (!props.limite_credito) return "$ 0.00"; // Valor por defecto

    const formatted = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(Number(props.limite_credito));

    // Inserta un espacio después del símbolo de dólar
    return formatted.replace('$', '$ ');
});

const formatFecha = (fecha) => {
    if (!fecha) return "00-00-00"; // Validación si la fecha no está definida

    const date = new Date();
    const month = date.toLocaleString('default', {month:'short'}); // Obtener el mes y agregar un 0 si es menor a 10

    return `${fecha} ${month}`;
};

// Llamada de ejemplo
</script>
<template>
    <section class="snap-start basis-4/12 shrink-0 mb-6">
        <Card>
            <template #title>
                <div class="flex flex-row justify-between items-end">
                    <p>{{ alias }}</p>
                    <div class="flex flex-row gap-2">
                        <Button icon="pi pi-pen-to-square" aria-label="Editar" size="small" />
                        <Button icon="pi pi-times" severity="danger" aria-label="Eliminar" size="small" />
                    </div>
            </div>
            </template>
            
            <template #subtitle>
                <p class="flex flex-row justify-between">
                    <span class="text-sm truncate max-w-64">{{ nombre }}</span>
                    <span v-if="limite_credito_format != '$ 0.00' " class="text-sm text-white max-w-20">{{ limite_credito_format }}</span>
                </p>
            </template>
            <template #content>
                <section class="flex flex-row justify-between mt-2">
                    <p class="flex flex-col items-center"> 
                        <span>fecha corte</span> 
                        <span  class="font-semibold">{{ formatFecha(props.fecha_corte) }}</span>
                    </p>
                    <p class="flex flex-col items-center">
                        <span>fecha pago</span>
                        <span class="font-semibold">{{ formatFecha(props.fecha_pago) }}</span>
                    </p>
                </section>
                
            </template>
        </Card>
    </section>
</template>



