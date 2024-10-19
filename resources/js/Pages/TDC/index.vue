<script setup>
//componentes personalizados
import tdc_card from "./components/tdc_card.vue";
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
import amex_card from "../../../../public/img/amex_card.png"

// variables reactivas
const mensaje_registro = ref("");
const mensaje_registro_visible = ref(false);
const severity = ref("");
const visible = ref(false);
const mostrar_panel_act_tarjeta = ref(false);

// Obtén los datos de la página
const { props } = usePage();
const bancos = ref(props.bancos);
const tdc = ref(props.tdc);


// Banco seleccionado por el usuario
const selected_banco = ref(null);

const fechas_pc = ref(null);
// Opciones para el Select basadas en los datos de bancos
const bancoOptions = ref(
    bancos.value.map((banco) => ({
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
    const fecha_corte = convert_string_to_date(fechas_pc.value[0]);
    const fecha_pago = convert_string_to_date(fechas_pc.value[1]);

    const diferenciaMilisegundos = fecha_pago - fecha_corte;
    const diferenciaDias = Math.ceil(
        diferenciaMilisegundos / (1000 * 60 * 60 * 24)
    );

    const fc = fecha_corte.getDate();
    const fp = fecha_pago.getDate();

    const fechas = {
        fecha_corte: fc,
        fecha_pago: fp,
        diferencia_dias: diferenciaDias,
    };

    return fechas;
};

const form = useForm({
    banco_id: null,
    alias: null,
    limite_credito: null,
    fecha_corte: null,
    fecha_pago: null,
    diferencia_dias: null,
});

const form_actualizar_tdc = useForm({
    id: null,
    banco_id: null,
    alias: null,
    limite_credito: null,
    fecha_corte: null,
    fecha_pago: null,
});
const fecha_corte_act = ref(null);
const fecha_pago_act = ref(null);

const errors = ref({}); // Define `errors` como un objeto reactivo
const submit = () => {
    const fechas = diferencia_fc_fp(fechas_pc);

    form.banco_id = selected_banco.value;
    form.fecha_corte = fechas["fecha_corte"];
    form.fecha_pago = fechas["fecha_pago"];
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
                severity.value = "success";
                form.reset();
                selected_banco.value = null;
                fechas_pc.value = null;

                messageStore.mostrarMensaje(response.mensaje, severity.value);
                // Actualiza tdc con los datos más recientes
                tdc.value = page.props.tdc;
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = "error";

                messageStore.mostrarMensaje(response.mensaje, severity.value);
            }
        },
    });
};

const confirm = useConfirm();
const confirmarEliminar = (tarjeta) => {
    // Almacenar la tarjeta seleccionada para eliminar
    confirm.require({
        message: `¿Estás seguro de eliminar la tarjeta ${tarjeta.nombre}?`,
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
                respuesta.severity = "info";
            } else {
                respuesta.severity = "error";
            }
            actualizar_arr_tarjetas(respuesta);
        },
    });
}
// metodo que se llama cuando se elimina una TDC
function actualizar_arr_tarjetas(respuesta) {
    messageStore.mostrarMensaje(respuesta.mensaje, respuesta.severity);

    if (respuesta.exito) {
        tdc.value = tdc.value.filter(
            (tarjeta) => tarjeta.id !== respuesta.tarjeta_id
        );
    }
}
function obtener_banco(label) {
  const bancoEncontrado = bancoOptions.value.find((banco) => banco.label === label);
  return bancoEncontrado ? bancoEncontrado.value : null;
}

const alias = ref(null);
const limite_credito = ref(null);
const fecha_corte = ref(null);
const fecha_pago = ref(null);

function actualizar_tarjeta(tarjeta){
    mostrar_panel_act_tarjeta.value = true;

    const id_banco = obtener_banco(tarjeta.nombre);

    selected_banco.value = id_banco;
    form_actualizar_tdc.id = tarjeta.id;
    form_actualizar_tdc.banco_id = selected_banco.value ;
    form_actualizar_tdc.alias = tarjeta.alias;
    form_actualizar_tdc.limite_credito = tarjeta.limite_credito;

    let fecha_actual = new Date(); // Fecha base actual

    // Crear copias independientes para cada fecha
    let fecha_pago = new Date(fecha_actual);   // Copia de `fecha_actual` para `fecha_pago`
    let fecha_corte = new Date(fecha_actual);  // Copia de `fecha_actual` para `fecha_corte`

    // Asignar días específicos a cada fecha
    fecha_pago.setDate(tarjeta.fecha_pago);    // `fecha_pago` obtiene el día de `tarjeta.fecha_pago`
    fecha_corte.setDate(tarjeta.fecha_corte);  // `fecha_corte` obtiene el día de `tarjeta.fecha_corte`

    fecha_corte_act.value = fecha_corte;
     fecha_pago_act.value = fecha_pago;

}

function act_tarjeta(){
    let fecha_corte = fecha_corte_act.value.getDate();
    let fecha_pago = fecha_pago_act.value.getDate();

    form_actualizar_tdc.fecha_corte = fecha_corte;
    form_actualizar_tdc.fecha_pago = fecha_pago;

    form_actualizar_tdc.put(route("tdc.actualizar",form_actualizar_tdc.id),{
        onError: (validationErrors) => {
            errors.value = validationErrors;
        },
        onSuccess: (page) => {
            const response = page.props.flash.data;
            if (response.exito) {
                severity.value = "success";
                messageStore.mostrarMensaje(response.mensaje, severity.value);
                // Actualiza tdc con los datos más recientes
                tdc.value = page.props.tdc;
            } else {
                mensaje_registro.value = response.mensaje;
                severity.value = "error";

                messageStore.mostrarMensaje(response.mensaje, severity.value);
            }
        },
    });
    
}

function limpiar_formularios(){
    selected_banco.value = null;
    
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
                            :key="item.id"
                            :id="item.id"
                            :nombre="item.nombre"
                            :alias="item.alias"
                            :limite_credito="item.limite_credito"
                            :fecha_corte="item.fecha_corte"
                            :fecha_pago="item.fecha_pago"
                            :diferencia_dias="item.diferencia_dias"
                            @tarjeta_eliminar="confirmarEliminar"
                            @actualizar_tarjeta = "actualizar_tarjeta"
                        />
                    </section>
                    <section v-show="mostrar_panel_act_tarjeta" class="col-span-2" >
                        <picture style="display: flex; flex-direction: row; justify-content: center;">
                            <img :src="amex_card" alt="amex" style="height: 150px; width: 200px;">
                        </picture>
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-4 grid-rows-3 place-items-center gap-x-4">
                                <div class="col-span-4 w-full min-h-24">
                                    <div class="flex flex-col items-start">
                                        <label for="banco" class="font-semibold w-28"
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
                                            v-model="form_actualizar_tdc.alias"
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
                                            v-model="form_actualizar_tdc.limite_credito"
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
                                        <DatePicker v-model="fecha_corte_act" dateFormat="dd/mm/y" />
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
                                            <DatePicker v-model="fecha_pago_act" dateFormat="dd/mm/y" />
                                        <small
                                            v-if="errors.limite_credito"
                                            class="text-red-500 text-sm"
                                            >{{ errors.limite_credito }}
                                        </small>
                                    </section>
                                </div>
                                        
                            </div>
                            <section class="w-full flex flex-row justify-end" >
                                <Button type="button" label="Actualizar" severity="secondary" @click="act_tarjeta"></Button>
                            </section>
                        </form>
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
                                    :invalid="errors.banco_id != undefined"
                                />
                            </div>
                            <small
                                v-if="errors.banco_id"
                                class="text-red-500 text-sm"
                                >{{ errors.banco_id }}</small
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
                                    v-model="form.limite_credito"
                                    inputId="limite"
                                    mode="currency"
                                    currency="MXN"
                                    :minFractionDigits="0"
                                    fluid
                                    placeholder="opcional"
                                />
                                <small
                                    v-if="errors.limite_credito"
                                    class="text-red-500 text-sm"
                                    >{{ errors.limite_credito }}
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
