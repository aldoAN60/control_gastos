<script setup>
import { defineProps, defineEmits, ref, computed } from "vue";

import { router } from '@inertiajs/vue3'

import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Select from "primevue/select";
import DatePicker from 'primevue/datepicker';
import ToggleSwitch from "primevue/toggleswitch";
import formatDate from "@/helpers/commons";


    const props = defineProps({
        visible: Boolean,
        selected_registry: Object,
        tdcOptions: Array,
        categoryOptions: Array,
        paymentMethodOptions: Array,
        payment_frequency: Array,
        spendTypeOptions: Array,
    });

    function format_registry(registry){
        return registry = {
            ...registry,
            is_credit: registry.purchase_registry_credit != null ? true : false,
            is_frequent: registry.purchase_registry_frequent != null ? true : false,

        }
    }

    const updated_registry = ref({
    id: null,
    concept: "",
    amount: null,
    payment_method_id: null,
    tdc_id: null,
    category_id: null,
    sub_category_id: null,
    spend_type: "",
    purchase_registry_credit_id: null,
    credit_payment_frequency_id: null,
    qty_payment: null,
    remain_payment: null,
    purchase_registry_frequent_id: null,
    frequent_payment_frequency_id: null, 
    next_insert_date: null,
    is_credit: false,
    is_frequent: false,
    created_at: null
});

const assignUpdatedRegistry = (registry) => {
    updated_registry.value = {
        id: registry.id ?? null,
        concept: registry.concept ?? "",
        amount: registry.amount ?? null,
        payment_method_id: registry.payment_method?.id ?? null,
        tdc_id: registry.tdc?.id ?? null,
        category_id: registry.category?.id ?? null,
        sub_category_id: registry.sub_category?.id ?? null,
        spend_type: registry.spend_type ?? "",
        purchase_registry_credit_id: registry.purchase_registry_credit?.id ?? null,
        credit_payment_frequency_id: registry.purchase_registry_credit?.payment_frequency?.id ?? null, 
        qty_payment: registry.purchase_registry_credit?.qty_payment ?? null,
        remain_payment: registry.purchase_registry_credit?.remain_payment ?? null,
        purchase_registry_frequent_id: registry.purchase_registry_frequent?.id ?? null,
        frequent_payment_frequency_id: registry.purchase_registry_frequent?.payment_frequency?.id ?? null,
        next_insert_date: registry.purchase_registry_frequent?.next_insert_date ? registry.purchase_registry_frequent?.next_insert_date : null,
        created_at: registry.created_at ?? null,
        is_credit: registry.is_credit ?? false,
        is_frequent: registry.is_frequent ?? false,
    };
};




// varaibles for props    
    const registry = ref(format_registry(props.selected_registry));
    const categoryOptions = ref(props.categoryOptions);
    const paymentMethodOptions = ref(props.paymentMethodOptions);
    const paymentFrequencyOptions = ref(props.payment_frequency);
    const spendTypeOptions = ref(props.spendTypeOptions);

    const subCategoryOptions = computed(() => {
        const category = categoryOptions.value.find(cat => cat.category_id === registry.value.category.id);
        return category ? category.sub_categories : [];
    });
    console.log(registry.value);
// Restablece la subcategoría cuando cambia la categoría
    const updateSubCategories = () => {
    registry.value.sub_category_id = null;
    };
 

    const emit = defineEmits(["update:visible", "update_registry"]);



    const closeDialog = () => {
        emit("update:visible", false);
    };

    function update_registry(){
        console.log("antes",registry.value);
        assignUpdatedRegistry(registry.value);
        console.log(updated_registry.value);

        router.put(route('pr.update'),updated_registry.value, {
            onSuccess:(data) => {
                console.info(data.props.flash.data);
            },
            onError: (validationErrors) => {
                console.error(validationErrors);
            }
        });
        // emit("update_registry", updated_registry.value);
    };

    // Función para mostrar/ocultar campos de compra frecuente
    const toggleFrequentFields = () => {
        if (!registry.is_frequent) {
            registry.value.purchase_registry_frequent.next_insert_date = null;
            registry.value.purchase_registry_frequent.payment_frequency = null;
        }
    };

    // Función para mostrar/ocultar campos de compra a crédito
    const toggleCreditFields = () => {
        if (!registry.is_credit) {
            registry.value.purchase_registry_credit.qty_payment = null;
            registry.value.purchase_registry_credit.payment_frequency = null;
            registry.value.purchase_registry_credit.remain_payment = null;
        }
    };

const selectedCreditPaymentFrequency = computed({
    get() {
        return registry.value.purchase_registry_credit?.payment_frequency?.id ?? null
    },
    set(value) {
        if (!registry.value.purchase_registry_credit) {
            registry.value.purchase_registry_credit = {};
        }
        if (!registry.value.purchase_registry_credit.payment_frequency) {
            registry.value.purchase_registry_credit.payment_frequency = {};
        }
        registry.value.purchase_registry_credit.payment_frequency.id = value;
    },
});
/** Para cantidad de pagos en creditos */
const selectedCreditQtyPayments = computed({
    get() {
        return registry.value.purchase_registry_credit?.qty_payment ?? null;
    },
    set(value) {
        if (!registry.value.purchase_registry_credit) {
            registry.value.purchase_registry_credit = {};
        }
        registry.value.purchase_registry_credit.qty_payment = value;
    },
});

/** Para el monto restante en creditos */
const selectedCreditRemainPayment = computed({
    get() {
        return registry.value.purchase_registry_credit?.remain_payment ?? null;
    },
    set(value) {
        if (!registry.value.purchase_registry_credit) {
            registry.value.purchase_registry_credit = {};
        }
        registry.value.purchase_registry_credit.remain_payment = value;
    },
});

/** Para frecuencia de pago en gastos frecuentes */
const selectedFrequentPaymentFrequency = computed({
    get() {
        return registry.value.purchase_registry_frequent?.payment_frequency?.id ?? null;
    },
    set(value) {
        if (!registry.value.purchase_registry_frequent) {
            registry.value.purchase_registry_frequent = {};
        }
        if (!registry.value.purchase_registry_frequent.payment_frequency) {
            registry.value.purchase_registry_frequent.payment_frequency = {};
        }
        registry.value.purchase_registry_frequent.payment_frequency.id = value;
    },
});

/** Para la fecha de la siguiente inserción en gastos frecuentes */
const selectedFrequentNextInsertDate = computed({
    get() {
        const dateStr = registry.value.purchase_registry_frequent?.next_insert_date;
        if (!dateStr) return null;

        // Convertir de "YYYY-MM-DD" a un objeto Date
        const [year, month, day] = dateStr.split("-").map(Number);
        return new Date(year, month - 1, day);
    },
    set(value) {
        if (!registry.value.purchase_registry_frequent) {
            registry.value.purchase_registry_frequent = {};
        }

        if (!value) {
            registry.value.purchase_registry_frequent.next_insert_date = null;
            return;
        }

        // Convertir de Date a "YYYY-MM-DD" para guardarlo en el registro
        const year = value.getFullYear();
        const month = String(value.getMonth() + 1).padStart(2, "0"); // Mes con 2 dígitos
        const day = String(value.getDate()).padStart(2, "0"); // Día con 2 dígitos

        registry.value.purchase_registry_frequent.next_insert_date = `${year}-${month}-${day}`;
    }
});


const createdAtDate = computed({
    get() {
        if (!registry.value.created_at) return null;

        // Convertir de "YYYY-MM-DD" a un objeto Date
        const [year, month, day] = registry.value.created_at.split("-").map(Number);
        return new Date(year, month - 1, day);
    },
    set(value) {
        if (!value) {
            registry.value.created_at = null;
            return;
        }

        // Convertir de Date a "YYYY-MM-DD" para guardarlo en el registro
        const year = value.getFullYear();
        const month = String(value.getMonth() + 1).padStart(2, "0"); // Mes en formato 2 dígitos
        const day = String(value.getDate()).padStart(2, "0"); // Día en formato 2 dígitos

        registry.value.created_at = `${year}-${month}-${day}`;
    }
});

</script>

<template>
    <Dialog 
        :visible="props.visible" 
        @update:visible="(val) => emit('update:visible', val)"
        modal 
        header="Editar Compra" 
        :style="{ width: '40rem' }"
    >
    <div class="p-fluid">
            <!-- Concepto -->
            <div class="field">
                <label for="concept">Concepto</label>
                <InputText id="concept" v-model="registry.concept" />
            </div>

            <!-- Monto -->
            <div class="field">
                <label for="amount">Monto</label>
                <InputNumber id="amount" v-model="registry.amount" mode="currency" currency="MXN" locale="es-MX" />
            </div>

            <!-- Tarjeta de Crédito -->
            <div class="field" v-if="registry.tdc">
                <label for="tdc">Tarjeta de Crédito</label>
                <Select 
                    id="tdc" 
                    v-model="registry.tdc.id" 
                    :options="tdcOptions" 
                    optionLabel="alias" 
                    optionValue="id"
                    placeholder="Selecciona una tarjeta"
                />
            </div>

            <!-- Categoría -->
            <div class="field">
                <label for="category">Categoría</label>
                <Select 
                    id="category" 
                    v-model="registry.category.id" 
                    :options="categoryOptions" 
                    optionLabel="category" 
                    optionValue="category_id"
                    placeholder="Selecciona una categoría"
                    @change="updateSubCategories"
                />
            </div>

            <!-- Subcategoría -->
            <div class="field">
                <label for="subCategory">Subcategoría</label>
                <Select 
                    id="subCategory" 
                    v-model="registry.sub_category.id" 
                    :options="subCategoryOptions" 
                    optionLabel="sub_category" 
                    optionValue="sub_category_id"
                    placeholder="Selecciona una subcategoría"
                />
            </div>

            <!-- Método de Pago -->
            <div class="field">
                <label for="paymentMethod">Método de Pago</label>
                <Select 
                    id="paymentMethod" 
                    v-model="registry.payment_method.id" 
                    :options="paymentMethodOptions" 
                    optionLabel="method" 
                    optionValue="id"
                    placeholder="Selecciona un método de pago"
                />
            </div>
            

            <!-- Tipo de Gasto -->
            <div class="field">
                <label for="spendType">Tipo de Gasto</label>
                <Select 
                    id="spendType" 
                    v-model="registry.spend_type" 
                    :options="spendTypeOptions" 
                    optionLabel="" 
                    optionValue="" 
                    placeholder="Selecciona el tipo de gasto"
                />
            </div>

            <!-- Fecha de Compra -->
            <div class="field">
                <label for="purchaseDate">Fecha de Compra</label>
                <DatePicker 
                    id="purchaseDate" 
                    v-model="createdAtDate"
                    dateFormat="dd 'de' MM 'del' yy" 
                />
            </div>
            <!-- compras a credito -->
            <div v-if="registry.is_credit">
                <div class="field">
                    <label for="paymentFrequency">Frecuencia de pago</label>
                    <Select 
                        id="paymentFrequency" 
                        v-model="selectedCreditPaymentFrequency" 
                        :options="paymentFrequencyOptions" 
                        optionLabel="frequency" 
                        optionValue="id" 
                        placeholder="Selecciona la frecuencia de pago"
                    />
                </div>

                <div class="field">
                    <label for="qtyPayments">Cantidad de pagos</label>
                    <InputNumber id="qtyPayments" v-model="selectedCreditQtyPayments"/>
                </div>

                <div class="field">
                    <label for="remainPayments">pagos restantes</label>
                    <InputNumber id="remainPayments" v-model="selectedCreditRemainPayment"/>
                </div>
            </div>

            <div v-if="registry.is_frequent">
                <div class="field">
                    <label for="paymentFrequency">Frecuencia de pago</label>
                    <Select 
                        id="paymentFrequency" 
                        v-model="selectedFrequentPaymentFrequency" 
                        :options="paymentFrequencyOptions" 
                        optionLabel="frequency" 
                        optionValue="id" 
                        placeholder="Selecciona la frecuencia de pago"
                    />
                </div>

                <div class="field">
                    <label for="nextInsertDate">Fecha de la siguiente inserción</label>
                    <DatePicker 
                        id="nextInsertDate" 
                        v-model="selectedFrequentNextInsertDate" 
                        dateFormat="dd/mm/yy"
                    />
                </div>
            </div>



        <div class="flex items-center mb-4">
            <label class="mr-2 font-medium">¿Es una compra con crédito?</label>
            <ToggleSwitch v-model="registry.is_credit" @change="toggleCreditFields"/>
        </div>
        <div class="flex items-center mb-4">
            <label class="mr-2 font-medium">¿Es una compra frecuente?</label>
            <ToggleSwitch v-model="registry.is_frequent" @change="toggleFrequentFields"/>
        </div>
    </div>

    

        <template #footer>
            <Button label="Cancelar" icon="pi pi-times" @click="closeDialog" class="p-button-text" />
            <Button label="Guardar" icon="pi pi-check" @click="update_registry" />
        </template>
    </Dialog>
</template>

