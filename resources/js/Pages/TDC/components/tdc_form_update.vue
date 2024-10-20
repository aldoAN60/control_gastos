<script setup>
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import DatePicker from "primevue/datepicker";
import Select from "primevue/select";
import { onMounted } from "vue";
import { ref } from "vue";

const tdc_data = defineProps({
    form:Object,
    bancos_catalogos:Array,
    errors: Object,
});
const cargando = ref(true);
const emit = defineEmits(['emitir_actualizacion']);

const fecha_corte = ref('');
const fecha_pago = ref('');


// Emitir evento cuando se hace click en el botón
function emitir_actualizacion() {
    obtener_dia_del_mes(tdc_data.form);
    emit('emitir_actualizacion', tdc_data.form);
}
onMounted(() => {
    obtener_fecha_completa(tdc_data.form);
    cargando.value = false;
});
function obtener_fecha_completa(form){
    let fecha_actual = new Date(); // Fecha base actual
    // Crear copias independientes para cada fecha
    fecha_pago.value = new Date(fecha_actual);   // Copia de `fecha_actual` para `fecha_pago`
    fecha_corte.value = new Date(fecha_actual);  // Copia de `fecha_actual` para `fecha_corte`
    // Asignar días específicos a cada fecha
    fecha_pago.value.setDate(form.fecha_pago);    // `fecha_pago` obtiene el día de `tarjeta.fecha_pago`
    fecha_corte.value.setDate(form.fecha_corte);  // `fecha_corte` obtiene el día de `tarjeta.fecha_corte`
}
function obtener_dia_del_mes(form){

    let fc = fecha_corte.value.getDate();
    let fp = fecha_pago.value.getDate();
    
    form.fecha_corte = fc;
    form.fecha_pago = fp;
}



</script>
<template>
    <div v-if="cargando">Cargando...</div>
    <div v-else>
<form @submit.prevent="submit">
        <div class="grid grid-cols-4 grid-rows-3 place-items-center gap-x-4">
            <div class="col-span-4 w-full min-h-24">
                <div class="flex flex-col items-start">
                    <label for="banco" class="font-semibold w-28"
                        >Bancos</label
                    >
                    <Select
                        v-model="form.banco_id"
                        :options="bancos_catalogos"
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
                <small
                    v-if="errors.banco_id"
                    class="text-red-500 text-sm"
                    >{{ errors.banco_id }}</small
                >
            </div>
            <div class="col-span-2 row-start-2 h-4/5 w-full">
                <section class="flex flex-col items-center ">
                    <label for="alias" class="font-semibold w-28">Alias</label>
                    <InputText
                        id="alias"
                        class="flex-auto"
                        v-model="form.alias"
                        autocomplete="off"
                        :invalid="errors.alias != undefined"
                    />
                    <small
                        v-if="errors.alias"
                        class="text-red-500 text-sm"
                        >{{ errors.alias }}
                    </small>
                </section>
            </div>
            <div class="col-span-2 col-start-3 row-start-2 h-4/5 w-full">
                <section class="flex flex-col items-center ">
                    <label for="limite" class="font-semibold w-28"
                        >Límite</label
                    >
                    <InputNumber
                        v-model="form.limite_credito"
                        inputId="limite"
                        mode="currency"
                        currency="MXN"
                        :minFractionDigits="0"
                        fluid
                        placeholder="opcional"
                        class="!w-2/4"
                    />
                    <small
                        v-if="errors.limite_credito"
                        class="text-red-500 text-sm"
                        >{{ errors.limite_credito }}
                    </small>
                </section>
            </div>
            <div class="col-span-2 col-start-1 row-start-3 h-4/5 w-full">
                <section class="flex flex-col items-center ">
                    <label for="fecha_corte" class="font-semibold w-28"
                        >Fecha de corte</label>
                    <DatePicker v-model="fecha_corte" dateFormat="dd/mm/y" />
                    <small
                        v-if="errors.limite_credito"
                        class="text-red-500 text-sm"
                        >{{ errors.limite_credito }}
                    </small>
                </section>
            </div>
            <div class="col-span-2 col-start-3 row-start-3 h-4/5 w-full">
                <section class="flex flex-col items-center ">
                    <label for="fecha_pago" class="font-semibold w-28"
                        >Fecha de pago</label>
                        <DatePicker v-model="fecha_pago" dateFormat="dd/mm/y" />
                    <small
                        v-if="errors.limite_credito"
                        class="text-red-500 text-sm"
                        >{{ errors.limite_credito }}
                    </small>
                </section>
            </div>
                    
        </div>
        <section class="w-full flex flex-row justify-end" >
            <Button type="button" label="Actualizar" severity="secondary" @click="emitir_actualizacion"></Button>
        </section>
    </form>
    </div>
     
</template>