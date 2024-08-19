<script setup>
import {ref} from "vue";
import { useForm, usePage} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';

import Select from 'primevue/select';
import { onMounted } from 'vue';

// variables reactivas
const mensaje_registro = ref('');
const mensaje_registro_visible = ref(false);
const severity = ref('');
const visible = ref(false);
// Obtén los datos de la página
const { props } = usePage();
const bancos = ref(props.bancos); // `bancos` debería ser una lista de objetos

// Banco seleccionado por el usuario
const selectedBanco = ref(null);

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
    form.banco_id = selectedBanco.value; 
    form.post(route('registrar_TDC'), {
        onError: (validationErrors) => {
            errors.value = validationErrors;
            console.log('Errores de validación:', errors.value);
        },
        onSuccess: (page) => {
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
               tarjeta de credito
        </template>
        <div>
            
        </div>
        <template #main_content >
            <Button label="Show" @click="visible = true" />

            <Dialog :unstyled="true" v-model:visible="visible" modal class="bg-dark-custom-bg-200" :style="{ width: '25rem' }">
                <template #header>
                    <div>
                        <h5>esto es un header tilin</h5>
                    </div>
                </template>
                    <div>
                        <form @submit.prevent="submit">
                        <span class="text-surface-500 dark:text-surface-400 block mb-8">Registra una tarjeta de credito</span>
                        
                        <div class="flex items-center gap-4 mb-4">
                        <label for="banco" class="font-semibold w-24">Bancos</label>
                        <Select 
                            v-model="selectedBanco" 
                            :options="bancoOptions"  
                            inputId="banco" 
                            filter 
                            optionLabel="label" 
                            optionValue="value"
                            placeholder="Seleccione un banco" 
                            checkmark 
                            :highlightOnSelect="false" 
                            class="w-full md:w-56" 
                        />
                        <span v-if="errors.banco_id" class="text-red-500 text-sm">{{ errors.banco_id }}</span>

                    </div>

                        <div class="flex items-center gap-4 mb-8">
                            <label for="alias" class="font-semibold w-24">Alias</label>
                            <InputText id="alias" class="flex-auto" v-model="form.alias" autocomplete="off" />
                            <span v-if="errors.alias" class="text-red-500 text-sm">{{ errors.alias }} </span>
                        </div>

                        <div class="flex items-center gap-4 mb-8">
                            <label for="limite" class="font-semibold w-24">Límite</label>
                            <InputNumber 
                                v-model="form.limite_credito" 
                                inputId="limite" 
                                mode="currency" 
                                currency="MXN" 
                                :minFractionDigits="0" 
                                fluid 
                            />
                            <span v-if="errors.limite_credito" class="text-red-500 text-sm">{{ errors.limite_credito }} </span>
                        </div>

                        <div class="flex flex-row justify-center items-center gap-4">
                            <div class="flex flex-col py-4 gap-1 mb-2">
                                <label for="dia-corte">Día de Corte</label>
                                <Select 
                                    v-model="form.fecha_corte" 
                                    inputId="dia-corte" 
                                    :options="dia_corte" 
                                    optionLabel="number" 
                                    class="w-full md:w-20" 
                                />
                            </div>
                            <div class="flex flex-col py-4 gap-1 mb-2">
                                <label for="dia-pago">Día de Pago</label>
                                <Select 
                                    v-model="form.fecha_pago" 
                                    inputId="dia-pago" 
                                    :options="dia_pago" 
                                    optionLabel="number" 
                                    class="w-full md:w-20" 
                                />
                            </div>
                        </div>
                    </form>
                    </div>
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