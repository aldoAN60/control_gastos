<script setup>

import Card from 'primevue/card';
import { computed} from 'vue';
import Button from 'primevue/button';

const props = defineProps({
    id: Number,
    nombre: String,
    alias: String,
    limite_credito: Number || null,
    fecha_corte: Number,
    fecha_pago: Number,
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

/**
 * Formatea las fechas de corte y pago basándose en el día del mes proporcionado y la fecha actual.
 *
 * @param {Object} fecha - Objeto que contiene las fechas de corte y pago.
 * @param {number} fecha.fecha_corte - Día del mes que representa la fecha de corte (1-31).
 * @param {number} fecha.fecha_pago - Día del mes que representa la fecha de pago (1-31).
 * @returns {Object} - Objeto con las fechas formateadas para la fecha de corte y fecha de pago.
 */
const formatFecha = (fecha) => {
    if (!fecha) return "00-00-00"; // Validación si la fecha no está definida

    const fecha_actual = new Date();
    
    let fa_es_mayor_fp = fecha_actual.getDate() > fecha.fecha_pago  ? 'mayor' : 'menor' ;

    let fecha_corte = null;
    let fecha_pago = null;

    let fc_es_mayor_fp = fecha.fecha_corte > fecha.fecha_pago ? true : false;
    

    if(fa_es_mayor_fp == 'mayor'){
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth()  + 1);

        const mes = mes_actual.toLocaleString('default', {month:'short'});
        fecha_pago = `${fecha.fecha_pago} ${mes}`;

    }else if(fa_es_mayor_fp == 'menor'){

        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth());

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        fecha_pago = `${fecha.fecha_pago} ${mes}`; 

    }

    if(fa_es_mayor_fp == 'mayor'){
        
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth() + 1);
        if(fc_es_mayor_fp){
            mes_actual.setMonth(fecha_actual.getMonth());
        }
        const mes = mes_actual.toLocaleString('default', {month:'short'});
        fecha_corte = `${fecha.fecha_corte} ${mes}`; 

    }else if(fa_es_mayor_fp == 'menor'){
        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth());

        if(fc_es_mayor_fp){
            mes_siguiente.setMonth(fecha_actual.getMonth() - 1);
        }

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        fecha_corte = `${fecha.fecha_corte} ${mes}`; 
    }

        const fechas_format = {
            'fecha_corte': fecha_corte,
            'fecha_pago': fecha_pago,
        };
        return fechas_format;
};

/**
 * Calcula y devuelve las fechas de corte y pago en formato legible basadas en los días proporcionados.
 *
 * @param {number} fc - Día del mes que representa la fecha de corte (1-31).
 * @param {number} fp - Día del mes que representa la fecha de pago (1-31).
 * @returns {Object} - Objeto con los detalles formateados para la fecha de corte y fecha de pago.
 */
const get_diferencia_fc_fp = (fc, fp) => {
    
    let respuesta = {
        'fecha_corte' : {
            'label' : 'Fecha corte',
            'fc' : null,
        },
        'fecha_pago' : {
            'label' : 'Fecha pago',
            'fp' : null
        }
    };
    let fechas = {
        'fecha_corte': fc,
        'fecha_pago': fp
    };

    let formato = formatFecha(fechas);
    respuesta['fecha_corte']['fc'] = formato['fecha_corte'];
    respuesta['fecha_pago']['fp'] = formato['fecha_pago'];
    
    return respuesta
};

const fechas_fc_fp = get_diferencia_fc_fp(props.fecha_corte,props.fecha_pago);

const emit = defineEmits(['tarjeta_eliminar','emitir_tdc_data']);

const eliminar_tarjeta = () => {
  emit('tarjeta_eliminar', { id: props.id, alias: props.alias });
};

function emitir_tdc_data(){
    emit('emitir_tdc_data',{
    id: props.id,
    nombre: props.nombre,
    alias: props.alias,
    limite_credito: props.limite_credito,
    fecha_corte: props.fecha_corte,
    fecha_pago: props.fecha_pago,
    });
}



</script>
<template>
    <section @click="emitir_tdc_data" class="snap-start basis-4/12 shrink-0 mb-6 min-w-full">
        <Card>
            <template #title>
                <div class="flex flex-row justify-between items-end">
                    <p>{{ alias }}</p>
                    <div class="flex flex-row gap-2">
                        <Button icon="pi pi-trash"  @click="eliminar_tarjeta()" aria-label="Delete" severity="danger" ></Button>
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
                        <span>{{ fechas_fc_fp.fecha_corte.label }}</span> 
                        <span class="font-semibold">{{ fechas_fc_fp.fecha_corte.fc }}</span>
                    </p>
                    <p class="flex flex-col items-center">
                        <span>{{ fechas_fc_fp.fecha_pago.label }}</span> 
                        <span class="font-semibold">{{ fechas_fc_fp.fecha_pago.fp }}</span>
                    </p>
                </section>
            </template>
        </Card>
    </section>
</template>



