<script setup>
//componentes personalizados
import tdc_card from "./components/tdc_card.vue";
import {ref} from "vue";
import { useForm, usePage} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import ScrollPanel from 'primevue/scrollpanel';
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
const selected_dia_corte = ref(null);
const selected_dia_pago = ref(null);

// Opciones para el Select basadas en los datos de bancos
const bancoOptions = ref(
    bancos.value.map(banco => ({
        value: banco.id,    
        label: banco.nombre,
    }))
);


const form = useForm({
    banco_id:null,
    alias:null,
    limite_credito:null,
    fecha_corte:null,
    fecha_pago:null,
})
const dia_corte_selecionado = ref();
const dia_pago_selecionado = ref();
const limite = ref();

const dia_corte = ref(
    Array.from({ length: 30 }, (_, i) => ({ number: i + 1 })) // Genera días del 1 al 30
);
const dia_pago = ref(
    Array.from({ length: 30 }, (_, i) => ({ number: i + 1 })) // Genera días del 1 al 30
);

const errors = ref({}); // Define `errors` como un objeto reactivo
const submit = () => {
    form.banco_id = selected_banco.value;
    form.fecha_corte = selected_dia_corte?.value?.number || null;
    form.fecha_pago = selected_dia_pago?.value?.number || null;


    // form.fecha_corte = dia_corte.value;
    form.post(route('registrar_TDC'), {
        onError: (validationErrors) => {
            errors.value = validationErrors;
        },
        onSuccess: (page) => {
            visible.value = false; // cerrar el modal
            const response = page.props.flash.data;
            if (response.exito) {
                mensaje_registro.value = response.mensaje;
                severity.value = 'success';
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = 'error'
            }
            mensaje_registro_visible.value = true;
        }
    });
};




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
                        <div class=" col-span-2 row-start-3  w-full">
                            <div class="flex flex-col items-center" >
                                <label for="dia-corte">Día de Corte</label>
                                <Select 
                                    v-model="selected_dia_corte" 
                                    inputId="dia-corte" 
                                    :options="dia_corte" 
                                    optionLabel="number" 
                                    class="!w-2/4 !md:w-20" 
                                    :invalid="errors.fecha_corte != undefined" 
                                />
                                <small v-if="errors.fecha_corte" class="text-red-500 text-sm">{{ errors.fecha_corte }} </small>
                            </div>
                        </div>
                        <div class="col-span-2 col-start-3 row-start-3 w-full">
                            <div class="flex flex-col items-center" >
                                <label for="dia-pago">Día de Pago</label>
                                <Select 
                                    v-model="selected_dia_pago" 
                                    inputId="dia-pago" 
                                    :options="dia_pago" 
                                    optionLabel="number" 
                                    class="!w-2/4 !md:w-20" 
                                    :invalid="errors.fecha_pago != undefined" 
                                />
                                <small v-if="errors.fecha_pago" class="text-red-500 text-sm">{{ errors.fecha_pago }} </small>
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