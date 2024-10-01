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
    diferencia_dias: Number,
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
    
    let fp_es_mayor_fa = fecha.fecha_pago < fecha_actual.getDate() ? 'menor' : 'mayor' ;

    let fecha_corte = null;
    let fecha_pago = null;

    let fc_es_mayor_fp = fecha.fecha_corte > fecha.fecha_pago ? true : false;
    

    if(fp_es_mayor_fa == 'mayor'){
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth());

        const mes = mes_actual.toLocaleString('default', {month:'short'});
        fecha_pago = `${fecha.fecha_pago} ${mes}`;

    }else if(fp_es_mayor_fa == 'menor'){

        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth() + 1);

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        fecha_pago = `${fecha.fecha_pago} ${mes}`; 

    }

    if(fp_es_mayor_fa == 'mayor'){
        const mes_actual = new Date(fecha_actual);
        mes_actual.setMonth(fecha_actual.getMonth() - 1);

        const mes = mes_actual.toLocaleString('default', {month:'short'});
        fecha_corte = `${fecha.fecha_corte} ${mes}`; 

    }else if(fp_es_mayor_fa == 'menor' && !fc_es_mayor_fp){
        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth() + 1);

        const mes = mes_siguiente.toLocaleString('default', {month:'short'});
        fecha_corte = `${fecha.fecha_corte} ${mes}`; 
    }else{
        const mes_siguiente = new Date(fecha_actual);
        mes_siguiente.setMonth(fecha_actual.getMonth());

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

const emit = defineEmits(['tarjeta_eliminar']);

const eliminar_tarjeta = () => {
    // console.log({ id: props.id, nombre: props.nombre });
  emit('tarjeta_eliminar', { id: props.id, nombre: props.nombre });
};



</script>
<template>
    <section class="snap-start basis-4/12 shrink-0 mb-6">
        <Card>
            <template #title>
                <div class="flex flex-row justify-between items-end">
                    <p>{{ alias }}</p>
                    <div class="flex flex-row gap-2">
                        <Button icon="pi pi-pen-to-square" aria-label="Editar" size="small" />
                            
                            <Button @click="eliminar_tarjeta()" label="Delete" severity="danger" outlined></Button>
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



