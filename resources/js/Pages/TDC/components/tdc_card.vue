<script setup>

import Card from 'primevue/card';
import { computed} from 'vue';
import Button from 'primevue/button';
import { router } from '@inertiajs/vue3';
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";
const props = defineProps({
    id: Number,
    nombre: String,
    alias: String,
    limite_credito: Number || null,
    fecha_corte: Number,
    fecha_pago: Number,
    diferencia_dias: Number,
});
const emit = defineEmits(['tarjeta_eliminada']);

const confirm = useConfirm();

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

const formatFecha = (fecha, fc_es_mayor) => {
    if (!fecha) return "00-00-00"; // Validación si la fecha no está definida

    const fecha_actual = new Date();
    if(fc_es_mayor){
        const mes_anterior = new Date(fecha_actual);
        mes_anterior.setMonth(fecha_actual.getMonth() - 1);

        const month = mes_anterior.toLocaleString('default', {month:'short'});
        
        return `${fecha} ${month}`;
    }else{
        const month = fecha_actual.toLocaleString('default', {month:'short'});

        return `${fecha} ${month}`;
    }
    
};

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

    respuesta['fecha_corte']['fc'] = formatFecha(fc, false);
    respuesta['fecha_pago']['fp'] = formatFecha(fp, false);

    if(fc > fp){
        respuesta['fecha_corte']['fc'] = formatFecha(fc, true);
    }
    
    return respuesta
};
const fechas_fc_fp = get_diferencia_fc_fp(props.fecha_corte,props.fecha_pago);

const eliminar_tarjeta = () => {
    confirm.require({
        message: '¿Deseas eliminar esta tarjeta?',
        header: 'Eliminar',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancelar',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Eliminar',
            severity: 'danger'
        },
        accept: () => {
            eliminar(props.id);
        },
        reject: () => {
            console.log("no chidote pa");
        }
    });
};
//eliminar tdc
function eliminar(id) {
        router.delete(route('tdc.eliminar', id), {
            onSuccess: (page) => {
                //respuesta desde el backend 
                const respuesta = page.props.flash.data;
                //asignacion del id de la tarjeta que se elimino
                respuesta.id = id;
                if(respuesta.exito){
                    respuesta.severity = 'info';

                }else{
                    respuesta.severity = 'error';

                }


                emit('tarjeta_eliminada', respuesta);
            }
        });
    }

</script>
<template>
    <section class="snap-start basis-4/12 shrink-0 mb-6">
        <Card>
            <template #title>
                <div class="flex flex-row justify-between items-end">
                    <p>{{ alias }}</p>
                    <div class="flex flex-row gap-2">
                        <Button icon="pi pi-pen-to-square" aria-label="Editar" size="small" />
                            <ConfirmDialog></ConfirmDialog>
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



