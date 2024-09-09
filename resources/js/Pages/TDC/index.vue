<script setup>
//componentes personalizados
import tdc_card from "./components/tdc_card.vue";
import {ref} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';

// variables reactivas
const mensaje_registro = ref('');
const mensaje_registro_visible = ref(false);
const severity = ref('');
const visible = ref(false);

// Obtén los datos de la página
const { props } = usePage();
const bancos = ref(props.bancos);
const tdc = ref(props.tdc);


// Banco seleccionado por el usuario
const selected_banco = ref(null);

const fechas_pc = ref(null);
// Opciones para el Select basadas en los datos de bancos
const bancoOptions = ref(
    bancos.value.map(banco => ({
        value: banco.id,
        label: banco.nombre,
    }))
);

const convert_string_to_date = (date_str) => {
    const fecha = new Date(date_str);

    if (isNaN(fecha.getTime())) {
        console.error("Fecha no válida");
        return null;
    }

    return fecha;
};


const diferencia_fc_fp = (fechas_pc) => {
    const fecha_corte  = convert_string_to_date(fechas_pc.value[0]);
    const fecha_pago = convert_string_to_date(fechas_pc.value[1]);

        const diferenciaMilisegundos = fecha_pago - fecha_corte;
        const diferenciaDias = Math.ceil(diferenciaMilisegundos / (1000 * 60 * 60 * 24));

        const fc = fecha_corte.getDate();
        const fp = fecha_pago.getDate();

        const fechas = {
            'fecha_corte': fc,
            'fecha_pago': fp,
            'diferencia_dias': diferenciaDias,
        };


    return fechas;

};

const form = useForm({
    banco_id:null,
    alias:null,
    limite_credito:null,
    fecha_corte:null,
    fecha_pago:null,
    diferencia_dias:null,
})

const errors = ref({}); // Define `errors` como un objeto reactivo
const submit = () => {
    const fechas = diferencia_fc_fp(fechas_pc);

    form.banco_id = selected_banco.value;
    form.fecha_corte = fechas['fecha_corte'];
    form.fecha_pago = fechas['fecha_pago'];
    form.diferencia_dias = fechas['diferencia_dias'];

    form.post(route('tdc.registrar'), {
        onError: (validationErrors) => {
            errors.value = validationErrors;
        },
        onSuccess: (page) => {
            visible.value = false; // cerrar el modal
            const response = page.props.flash.data;
            if (response.exito) {
                mensaje_registro.value = response.mensaje;
                severity.value = 'success';
                
                // Actualiza tdc con los datos más recientes
                tdc.value = page.props.tdc;
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = 'error'
            }
            mensaje_registro_visible.value = true;
        }
    });
};

// metodo que se llama cuando se elimina una TDC
function actualizar_tdc(respuesta){
    mensaje_registro.value = respuesta.mensaje;
    severity.value = respuesta.severity;
    mensaje_registro_visible.value = true;

    if(respuesta.exito){
        tdc.value = tdc.value.filter((tarjeta) => tarjeta.id !== respuesta.id);
    }
}


</script>
<template>
    <AppLayout title="TDC" :mensaje_visible="mensaje_registro_visible" :mensaje="mensaje_registro" :severity="severity">
        <template #header>
            Tarjetas de credito
        </template>
        <template #main_content >
            <div class="grid grid-cols-2 grid-rows-1 gap-2 mb-3">
                <div class="flex justify-start items-center">
                    <h3 class="font-semibold text-xl " >Tarjetas de credito registradas</h3>
                </div>
                <div class="flex justify-end" >
                    <Button label="registrar" @click="visible = true" />
                </div>
            </div>
            <!-- card con la info de las tarjetas de credito -->
            <section class="flex flex-row items-start gap-3 overflow-x-scroll " >
                <tdc_card 
                    v-for="item in tdc" 
                    :key="item.id" 

                    :id="item.id" 
                    :nombre="item.nombre" 
                    :alias="item.alias" 
                    :limite_credito="item.limite_credito" 
                    :fecha_corte="item.fecha_corte" 
                    :fecha_pago="item.fecha_pago"
                    :diferencia_dias="item.diferencia_dias"
                    @tarjeta_eliminada="actualizar_tdc"
                    />
                </section>
     <!-- modal para registrar una tarjeta de credito -->
            <Dialog v-model:visible="visible" modal :style="{ width: '30rem' }">
                <template #header>
                    <div>
                        <h5 class="font-semibold " >Registrar tarjeta de credito</h5>
                    </div>
                </template>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-4 grid-rows-3 place-items-center gap-x-4">
                        <div class="col-span-4 w-full min-h-24">
                            <div class="flex flex-col items-start" >
                                <label for="banco" class="font-semibold w-24">Bancos</label>
                            <Select 
                                v-model="selected_banco" 
                                :options="bancoOptions"  
                                inputId="banco" 
                                filter 
                                optionLabel="label" 
                                optionValue="value"
                                placeholder="Seleccione un banco" 
                                checkmark 
                                :highlightOnSelect="false" 
                                class="!w-full !md:w-56" 
                                :invalid="errors.banco_id != undefined" 
                            />
                            </div>
                        <small v-if="errors.banco_id" class="text-red-500 text-sm">{{ errors.banco_id }}</small>
                        </div>
                        <div class="col-span-2 row-start-2 h-4/5">
                            <section class="flex flex-col items-start" >
                                <label for="alias" class="font-semibold w-24">Alias</label>
                                <InputText  id="alias" class="flex-auto" v-model="form.alias" autocomplete="off" :invalid="errors.alias != undefined"  />
                                <small v-if="errors.alias" class="text-red-500 text-sm">{{ errors.alias }} </small>
                            </section>
                        </div>
                        <div class="col-span-2 col-start-3 row-start-2 h-4/5 ">
                            <section class="flex flex-col items-start">
                                <label for="limite" class="font-semibold w-24">Límite</label>
                                <InputNumber 
                                    v-model="form.limite_credito" 
                                    inputId="limite" 
                                    mode="currency" 
                                    currency="MXN" 
                                    :minFractionDigits="0" 
                                    fluid 
                                    placeholder="opcional" 
                                    
                                />
                                <small v-if="errors.limite_credito" class="text-red-500 text-sm">{{ errors.limite_credito }} </small>
                            </section>
                        </div>
                        <div class="col-span-4 w-full min-h-24">
                            <div class="flex flex-col items-start">
                                <label for="banco" class="font-semibold w-full">fecha de corte y fecha de pago</label>
                                <DatePicker class="!w-full"  v-model="fechas_pc" selectionMode="range" :manualInput="false" dateFormat="dd/mm/y"   :numberOfMonths="2"/>
                            </div>
                        </div>
                    </div>
                </form>
                <template #footer >
                    <div class="flex justify-end gap-2">
                        <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
                        <Button type="button" label="Guardar" @click="submit"></Button>
                    </div>
                </template>
            </Dialog>
            
        </template>

    </AppLayout>
</template>