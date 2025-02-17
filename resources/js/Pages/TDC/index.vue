<script setup>
//componentes personalizados
import tdc_card from "./components/tdc_card.vue";
import tdc_form_update from "./components/tdc_form_update.vue";
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import DatePicker from "primevue/datepicker";
import Select from "primevue/select";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import { router } from "@inertiajs/vue3";
import messageStore from "@/stores/messageStore";

// variables reactivas
const mensaje_registro = ref("");
const mensaje_registro_visible = ref(false);
const severity = ref("");
const visible = ref(false);
const mostrar_panel_act_tarjeta = ref(false);

// Obtén los datos de la página
const { props } = usePage();
const banks = ref(props.banks);
const tdc = ref(props.tdc);
// Banco seleccionado por el usuario
const selected_banco = ref(null);

const fechas_pc = ref(null);
// Opciones para el Select basadas en los datos de banks
const bancoOptions = ref(
    banks.value.map((banco) => ({
        value: banco.id,
        label: banco.name,
    }))
);
const convert_string_to_date = (date_str) => {
    const fecha = new Date(date_str);

    if (isNaN(fecha.getTime())) {
        return null;
    }

    return fecha;
};

const diferencia_fc_fp = (fechas_pc) => {
    const statement_date = convert_string_to_date(fechas_pc.value[0]);
    const payment_date = convert_string_to_date(fechas_pc.value[1]);

    const diferenciaMilisegundos = payment_date - statement_date;
    const diferenciaDias = Math.ceil(
        diferenciaMilisegundos / (1000 * 60 * 60 * 24)
    );

    const fc = statement_date.getDate();
    const fp = payment_date.getDate();

    const fechas = {
        statement_date: fc,
        payment_date: fp,
        diferencia_dias: diferenciaDias,
    };

    return fechas;
};

const form = useForm({
    bank_id: null,
    alias: null,
    credit_limit: null,
    statement_date: null,
    payment_date: null,
    diferencia_dias: null,
});

const form_actualizar_tdc = useForm({
    id: null,
    bank_id: null,
    alias: null,
    credit_limit: null,
    statement_date: null,
    payment_date: null,
});
const statement_date_act = ref(null);
const payment_date_act = ref(null);

const errors = ref({}); // Define `errors` como un objeto reactivo
const submit = () => {
    const fechas = diferencia_fc_fp(fechas_pc);

    form.bank_id = selected_banco.value;
    form.statement_date = fechas["statement_date"];
    form.payment_date = fechas["payment_date"];
    form.diferencia_dias = fechas["diferencia_dias"];

    form.post(route("tdc.registrar"), {
        onError: (validationErrors) => {
            errors.value = validationErrors;
        },
        onSuccess: (page) => {
            visible.value = false; // cerrar el modal
            const response = page.props.flash.data;
            if (response.exito) {
                mensaje_registro.value = response.mensaje;
                severity.value = response.severity;
                form.reset();
                selected_banco.value = null;
                fechas_pc.value = null;

                messageStore.mostrarMensaje(response.mensaje, severity.value);
                // Actualiza tdc con los datos más recientes
                tdc.value = page.props.tdc;
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = response.severity

                messageStore.mostrarMensaje(response.mensaje, severity.value);
            }
        },
    });
};

const confirm = useConfirm();
const confirmarEliminar = (tarjeta) => {
    // Almacenar la tarjeta seleccionada para eliminar
    confirm.require({
        message: `¿Estás seguro de eliminar la tarjeta ${tarjeta.alias}?`,
        header: "Eliminar",
        icon: "pi pi-info-circle",
        rejectLabel: "Cancelar",
        rejectProps: {
            label: "Cancelar",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Eliminar",
            severity: "danger",
        },
        accept: () => {
            eliminarTarjeta(tarjeta.id); // Lógica de eliminación
        },
        reject: () => {
            console.log("Eliminación cancelada");
        },
    });
};

function eliminarTarjeta(id) {
    router.delete(route("tdc.eliminar", id), {
        onSuccess: (page) => {
            const respuesta = page.props.flash.data;
            respuesta.tarjeta_id = id;

            // Determinamos el tipo de mensaje según el estado de la eliminación.
            if (respuesta.exito) {
                actualizar_arr_tarjetas('DELETE',respuesta.tarjeta_id);
            }
            mensaje_registro.value = respuesta.mensaje;
            severity.value = respuesta.severity;
            messageStore.mostrarMensaje(respuesta.mensaje, severity.value);
        },
    });
}
const tdc_card_key = ref(0);
// metodo que se llama cuando se elimina una TDC
function actualizar_arr_tarjetas(tipo_request, data = false) {

    if (tipo_request === 'DELETE') {
        tdc.value = tdc.value.filter(
            (tarjeta) => tarjeta.id !== data
        );
    }
    if(tipo_request === 'PUT'){
        tdc.value = tdc.value.map(tarjeta => {
            if(tarjeta.id == data.id){
                return {
                    ...tarjeta,
                    statement_date: data.statement_date,
                    payment_date: data.payment_date,
                    alias: data.alias,
                    credit_limit: data.credit_limit,
                };
            }
            return tarjeta; // Devolver la tarjeta original si no coincide el id
        });
        tdc_card_key.value++;
    }
}
function obtener_banco(label) {
  const bancoEncontrado = bancoOptions.value.find((banco) => banco.label === label);
  return bancoEncontrado ? bancoEncontrado.value : null;
}
function llenar_form_act_tdc(tarjeta){
    const id_banco = obtener_banco(tarjeta.name);

    selected_banco.value = id_banco;
    form_actualizar_tdc.id = tarjeta.id;
    form_actualizar_tdc.bank_id = selected_banco.value ;
    form_actualizar_tdc.alias = tarjeta.alias;
    form_actualizar_tdc.credit_limit = tarjeta.credit_limit;
    form_actualizar_tdc.statement_date = tarjeta.statement_date;
    form_actualizar_tdc.payment_date = tarjeta.payment_date;
    mostrar_panel_act_tarjeta.value = true;
}
function actualizar_tarjeta(){
    form_actualizar_tdc.put(route("tdc.actualizar",form_actualizar_tdc.id),{
        onError: (validationErrors) => {
            errors.value = validationErrors;
        },
        onSuccess: (page) => {
            const response = page.props.flash.data;
            if (response.exito) {
                severity.value = response.severity;
                mostrar_panel_act_tarjeta.value = false;
                messageStore.mostrarMensaje(response.mensaje, severity.value);
                // Actualiza tdc con los datos más recientes
                actualizar_arr_tarjetas('PUT',response.data);
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = response.severity;
                messageStore.mostrarMensaje(response.mensaje, severity.value);
            }
        },
    });
    
}
</script>
<template>
    <AppLayout
        title="TDC"
        :mensaje_visible="mensaje_registro_visible"
        :mensaje="mensaje_registro"
        :severity="severity"
    >
        <template #header> Tarjetas de credito </template>
        <template #main_content>
            <div class="grid grid-cols-2 grid-rows-1 gap-2 mb-3">
                <div class="flex justify-start items-center">
                    <h3 class="font-semibold text-xl">
                        Tarjetas de credito registradas
                    </h3>
                </div>
                <div class="flex justify-end">
                    <Button label="registrar" @click="visible = true" />
                </div>
            </div>
            <!-- card con la info de las tarjetas de credito -->
            <ConfirmDialog></ConfirmDialog>
            <!-- <section class="flex flex-row items-start gap-3 overflow-x-scroll"> -->
                <div class="grid grid-cols-3 grid-rows-1 gap-2">
                    <section class="flex flex-col items-start gap-3 overflow-y-scroll h-128  max-w-sm  px-3">
                        <tdc_card
                            v-for="item in tdc"
                            :key="tdc_card_key"
                            :id="item.id"
                            :bank_id="item.bank_id"
                            :name="item.name"
                            :alias="item.alias"
                            :credit_limit="item.credit_limit"
                            :statement_date="item.statement_date"
                            :payment_date="item.payment_date"
                            :diferencia_dias="item.diferencia_dias"
                            @tarjeta_eliminar="confirmarEliminar"
                            @emitir_tdc_data = "llenar_form_act_tdc"
                        />
                    </section>
                    <section v-show="mostrar_panel_act_tarjeta" class="col-span-2" >
                        <tdc_form_update
                            v-if="mostrar_panel_act_tarjeta"
                            :form="form_actualizar_tdc"
                            :banks_catalogos="bancoOptions"
                            :errors="errors"
                            @emitir_actualizacion = "actualizar_tarjeta"
                        />
                    </section>
                </div>
            
            <!-- modal para registrar una tarjeta de credito -->
            <Dialog v-model:visible="visible" modal :style="{ width: '30rem' }">
                <template #header>
                    <div>
                        <h5 class="font-semibold">
                            Registrar tarjeta de credito
                        </h5>
                    </div>
                </template>
                <form @submit.prevent="submit">
                    <div
                        class="grid grid-cols-4 grid-rows-3 place-items-center gap-x-4"
                    >
                        <div class="col-span-4 w-full min-h-24">
                            <div class="flex flex-col items-start">
                                <label for="banco" class="font-semibold w-24"
                                    >Bancos</label
                                >
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
                                    :invalid="errors.bank_id != undefined"
                                />
                            </div>
                            <small
                                v-if="errors.bank_id"
                                class="text-red-500 text-sm"
                                >{{ errors.bank_id }}</small
                            >
                        </div>
                        <div class="col-span-2 row-start-2 h-4/5">
                            <section class="flex flex-col items-start">
                                <label for="alias" class="font-semibold w-24"
                                    >Alias</label
                                >
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
                        <div class="col-span-2 col-start-3 row-start-2 h-4/5">
                            <section class="flex flex-col items-start">
                                <label for="limite" class="font-semibold w-24"
                                    >Límite</label
                                >
                                <InputNumber
                                    v-model="form.credit_limit"
                                    inputId="limite"
                                    mode="currency"
                                    currency="MXN"
                                    :minFractionDigits="0"
                                    fluid
                                    placeholder="opcional"
                                />
                                <small
                                    v-if="errors.credit_limit"
                                    class="text-red-500 text-sm"
                                    >{{ errors.credit_limit }}
                                </small>
                            </section>
                        </div>
                        <div class="col-span-4 w-full min-h-24">
                            <div class="flex flex-col items-start">
                                <label
                                    for="fechas_pc"
                                    class="font-semibold w-full"
                                    >fecha de corte y fecha de pago</label
                                >
                                <DatePicker
                                    class="!w-full"
                                    v-model="fechas_pc"
                                    selectionMode="range"
                                    :manualInput="false"
                                    dateFormat="dd/mm/y"
                                    :numberOfMonths="2"
                                />
                            </div>
                        </div>
                    </div>
                </form>
                <template #footer>
                    <div class="flex justify-end gap-2">
                        <Button
                            type="button"
                            label="Cancelar"
                            severity="secondary"
                            @click="visible = false"
                        ></Button>
                        <Button
                            type="button"
                            label="Guardar"
                            @click="submit"
                        ></Button>
                    </div>
                </template>
            </Dialog>

        </template>
    </AppLayout>
</template>
