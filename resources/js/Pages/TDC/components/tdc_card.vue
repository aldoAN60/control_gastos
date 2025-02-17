<script setup>

import Card from 'primevue/card';
import { computed} from 'vue';
import Button from 'primevue/button';

const props = defineProps({
    id: Number,
    bank_id: Number,
    name: String,
    alias: String,
    credit_limit: Number || null,
    statement_date: Number,
    payment_date: Number,
});



const credit_limit_format = computed(() => {
    if (!props.credit_limit) return "$ 0.00"; // Valor por defecto

    const formatted = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(Number(props.credit_limit));

    // Inserta un espacio después del símbolo de dólar
    return formatted.replace('$', '$ ');
});

/**
 * Formatea las fechas de corte y pago basándose en el día del mes proporcionado y la fecha actual.
 *
 * @param {Object} fecha - Objeto que contiene las fechas de corte y pago.
 * @param {number} fecha.statement_date - Día del mes que representa la fecha de corte (1-31).
 * @param {number} fecha.payment_date - Día del mes que representa la fecha de pago (1-31).
 * @returns {Object} - Objeto con las fechas formateadas para la fecha de corte y fecha de pago.
 */
const formatFecha = (fecha) => {
    if (!fecha) return "00-00-00"; // Validación si la fecha no está definida

    const fecha_actual = new Date();
    
    let fa_es_mayor_fp = fecha_actual.getDate() > fecha.payment_date  ? 'mayor' : 'menor' ;

    let statement_date = null;
    let payment_date = null;

    let fc_es_mayor_fp = fecha.statement_date > fecha.payment_date ? true : false;
    

    if(fa_es_mayor_fp == 'mayor'){
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth()  + 1);

        const mes = mes_actual.toLocaleString('default', {month:'short'});
        payment_date = `${fecha.payment_date} ${mes}`;

    }else if(fa_es_mayor_fp == 'menor'){

        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth());

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        payment_date = `${fecha.payment_date} ${mes}`; 

    }

    if(fa_es_mayor_fp == 'mayor'){
        
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth() + 1);
        if(fc_es_mayor_fp){
            mes_actual.setMonth(fecha_actual.getMonth());
        }
        const mes = mes_actual.toLocaleString('default', {month:'short'});
        statement_date = `${fecha.statement_date} ${mes}`; 

    }else if(fa_es_mayor_fp == 'menor'){
        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth());

        if(fc_es_mayor_fp){
            mes_siguiente.setMonth(fecha_actual.getMonth() - 1);
        }

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        statement_date = `${fecha.statement_date} ${mes}`; 
    }

        const fechas_format = {
            'statement_date': statement_date,
            'payment_date': payment_date,
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
        'statement_date' : {
            'label' : 'Fecha corte',
            'fc' : null,
        },
        'payment_date' : {
            'label' : 'Fecha pago',
            'fp' : null
        }
    };
    let fechas = {
        'statement_date': fc,
        'payment_date': fp
    };

    let formato = formatFecha(fechas);
    respuesta['statement_date']['fc'] = formato['statement_date'];
    respuesta['payment_date']['fp'] = formato['payment_date'];
    
    return respuesta
};

const fechas_fc_fp = get_diferencia_fc_fp(props.statement_date,props.payment_date);

const emit = defineEmits(['tarjeta_eliminar','emitir_tdc_data']);

const eliminar_tarjeta = () => {
  emit('tarjeta_eliminar', { id: props.id, alias: props.alias });
};

function emitir_tdc_data(){
    emit('emitir_tdc_data',{
    id: props.id,
    bank_id: props.bank_id,
    name: props.name,
    alias: props.alias,
    credit_limit: props.credit_limit,
    statement_date: props.statement_date,
    payment_date: props.payment_date,
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
                    <span class="text-sm truncate max-w-64">{{ name }}</span>
                    <span v-if="credit_limit_format != '$ 0.00' " class="text-sm text-white max-w-20">{{ credit_limit_format }}</span>
                </p>
            </template>
            <template #content>
                <section class="flex flex-row justify-between mt-2">
                    <p class="flex flex-col items-center"> 
                        <span>{{ fechas_fc_fp.statement_date.label }}</span> 
                        <span class="font-semibold">{{ fechas_fc_fp.statement_date.fc }}</span>
                    </p>
                    <p class="flex flex-col items-center">
                        <span>{{ fechas_fc_fp.payment_date.label }}</span> 
                        <span class="font-semibold">{{ fechas_fc_fp.payment_date.fp }}</span>
                    </p>
                </section>
            </template>
        </Card>
    </section>
</template>



