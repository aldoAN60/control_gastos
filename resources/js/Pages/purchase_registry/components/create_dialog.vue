<script setup>
    import { ref, computed } from "vue";

    //inertia
    import { useForm } from "@inertiajs/vue3";
    // prime vue componentes
    import Dialog from "primevue/dialog";
    import InputText from "primevue/inputtext";
    import InputNumber from "primevue/inputnumber";
    import Select from "primevue/select";
    import DatePicker from "primevue/datepicker";
    import Button from "primevue/button";
    import ToggleSwitch from "primevue/toggleswitch";




    const props = defineProps({
        visible: Boolean,
        tdcOptions: Array,
        categoryOptions: Array,
        paymentMethodOptions: Array,
        payment_frequency: Array,
        spendTypeOptions: Array,
    });
    
    // variables for selects
    const tdcOptions = ref(props.tdcOptions);
    const paymentMethodOptions = ref(props.paymentMethodOptions);
    const paymentFrequencyOptions = ref(props.payment_frequency);
    const spendTypeOptions = ref(props.spendTypeOptions);
    const categoryOptions =ref( props.categoryOptions);
    const subCategoryOptions = computed(() => {
    const category = categoryOptions.value.find(cat => cat.category_id === form.category_id);
    return category ? category.sub_categories : [];
    });

// Restablece la subcategoría cuando cambia la categoría
const updateSubCategories = () => {
  form.sub_category_id = null;
};
const form = useForm({
    tdc_id: null,
    concept: "",
    amount: null,
    category_id: null,
    sub_category_id: null,
    spend_type: "",
    payment_method_id: null,
    payment_frequency_id: null,
    next_insert_date: null,
    qty_payment: null,
    remain_payment: null,
    is_credit: false,
    is_frequent: false,
});

const emit = defineEmits(["update:visible",'info_message']);

const closeDialog = () => {
    emit("update:visible", false);
    // form.reset();
};
    function create_registry(){
        form.post(route('pr.create'), {
            preserveState: true,
            only: ['purchase_registries', 'flash'],
            onError: (validationErrors) => {
                console.error(validationErrors);
            },
            onSuccess: (data) => {
                console.log(data);
                // Verifica si hay un mensaje flash en la respuesta
                if (data.props.flash && data.props.flash.data) {
                    emit("info_message", data.props.flash.data);
                }

                emit("update:visible", false);
                // form.reset();
            },
        });
    }

    // Función para mostrar/ocultar campos de compra frecuente
    const toggleFrequentFields = () => {
        if (!form.is_frequent) {
            form.payment_frequency_id = null;
            form.next_insert_date = null;
        }
    };

    // Función para mostrar/ocultar campos de compra a crédito
    const toggleCreditFields = () => {
        if (!form.is_credit) {
            form.qty_payment = null;
            form.remain_payment = null;
        }
    };
    const tdcOptionsFormatted = computed(() => {
        return tdcOptions.value.map(tdc => ({
            value: tdc.id,
            label: `${tdc.alias} - ${tdc.name}`,
        }));
    });



</script>

<template>
    <Dialog
    :visible="props.visible" 
    @update:visible="(val) => emit('update:visible', val)"
    modal
    header="Registrar Compra" 
    :style="{ width: '40rem' }"
    >
        <form @submit.prevent="create_registry" class="p-6 rounded-lg shadow-md">

        <!-- Concepto -->
        <InputText 
            v-model="form.concept" 
            placeholder="Concepto" 
            :invalid="!!form.errors.concept" 
            class="w-full mb-4" 
        />
        <small v-if="form.errors.concept" class="text-red-500 text-sm">
            {{ form.errors.concept }}
        </small>


        <!-- Monto -->
        <InputNumber 
            v-model="form.amount" 
            placeholder="Monto" 
            class="w-full mb-4" 
            mode="currency" 
            currency="MXN" 
            locale="es-MX"
            :invalid="!!form.errors.amount"
        />
        <small v-if="form.errors.amount" class="text-red-500 text-sm">
            {{ form.errors.amount }}
        </small>

        <!-- Categoría -->
        <Select 
            v-model="form.category_id" 
            :options="categoryOptions" 
            optionLabel="category" 
            optionValue="category_id" 
            placeholder="Selecciona una categoría" 
            class="w-full mb-4" 
            :invalid="!!form.errors.category_id"
            @change="updateSubCategories"
        />
        <small v-if="form.errors.category_id" class="text-red-500 text-sm">
            {{ form.errors.category_id }}
        </small>

        <!-- Subcategoría -->
        <Select 
            v-model="form.sub_category_id" 
            :options="subCategoryOptions" 
            optionLabel="sub_category" 
            optionValue="sub_category_id" 
            placeholder="Selecciona una subcategoría" 
            class="w-full mb-4" 
            :invalid="!!form.errors.sub_category_id"
        />
        <small v-if="form.errors.category_id" class="text-red-500 text-sm">
            {{ form.errors.category_id }}
        </small>

        <!-- Tipo de gasto -->
        <Select 
            v-model="form.spend_type" 
            :options="spendTypeOptions" 
            optionLabel="" 
            optionValue="" 
            placeholder="Selecciona un tipo de gasto" 
            class="w-full mb-4" 
            :invalid="!!form.errors.spend_type"
        />
        <small v-if="form.errors.spend_type" class="text-red-500 text-sm">
            {{ form.errors.spend_type }}
        </small>

        <!-- Método de pago -->
        <Select 
            v-model="form.payment_method_id" 
            :options="paymentMethodOptions" 
            optionLabel="method" 
            optionValue="id" 
            placeholder="Selecciona un método de pago" 
            class="w-full mb-4" 
            :invalid="!!form.errors.payment_method_id"
        />
        <small v-if="form.errors.payment_method_id" class="text-red-500 text-sm">
            {{ form.errors.payment_method_id }}
        </small>
         <!-- Tarjeta de crédito -->
        <div v-if="form.payment_method_id == 1">

            <Select 
                v-model="form.tdc_id" 
                :options="tdcOptionsFormatted" 
                optionLabel="label" 
                optionValue="value" 
                placeholder="Selecciona una tarjeta" 
                class="w-full mb-4" 
                :invalid="!!form.errors.tdc_id"
            />
            <small v-if="form.errors.tdc_id" class="text-red-500 text-sm">
                {{ form.errors.tdc_id }}
            </small>
        </div>

        <!-- 🔄 Switch para gasto frecuente -->
        <div class="flex items-center mb-4">
            <label class="mr-2 font-medium">¿Es una compra frecuente?</label>
            <ToggleSwitch v-model="form.is_frequent" @change="toggleFrequentFields"/>
        </div>
        <div  v-if="form.is_frequent">
            <!-- Frecuencia de pago -->
            <Select 
                v-model="form.payment_frequency_id" 
                :options="paymentFrequencyOptions" 
                optionLabel="frequency" 
                optionValue="id" 
                placeholder="Selecciona una frecuencia de pago" 
                class="w-full mb-4" 
                :invalid="!!form.errors.payment_frequency_id"
            />
            <small v-if="form.errors.payment_frequency_id" class="text-red-500 text-sm">
                {{ form.errors.payment_frequency_id }}
            </small>
            <!-- 📅 Fecha de próxima inserción (Solo si es frecuente) -->
            <DatePicker 
                v-model="form.next_insert_date" 
                dateFormat="yy-mm-dd" 
                placeholder="Selecciona una fecha" 
                class="w-full mb-4" 
                :invalid="!!form.errors.next_insert_date"
            />
            <small v-if="form.errors.next_insert_date" class="text-red-500 text-sm">
                {{ form.errors.next_insert_date }}
            </small>
        </div>

        <!-- 🔄 Switch para gasto con crédito -->
        <div class="flex items-center mb-4">
            <label class="mr-2 font-medium">¿Es una compra con crédito?</label>
            <ToggleSwitch v-model="form.is_credit" @change="toggleCreditFields"/>
        </div>

        <!-- 📅 Campos adicionales si es crédito -->
        <div v-if="form.is_credit">
            <InputNumber 
                v-model="form.qty_payment" 
                placeholder="Cantidad de pagos" 
                class="w-full mb-4" 
                :invalid="!!form.errors.qty_payment"
            />
            <small v-if="form.errors.qty_payment" class="text-red-500 text-sm">
                {{ form.errors.qty_payment }}
            </small>
            <InputNumber 
                v-model="form.remain_payment" 
                placeholder="Pagos restantes (opcional)" 
                class="w-full mb-4" 
                :invalid="!!form.errors.remain_payment"
            />
            <small v-if="form.errors.remain_payment" class="text-red-500 text-sm">
                {{ form.errors.remain_payment }}
            </small>
        </div>
    </form>
        <template #footer>
            <Button label="Cancelar" icon="pi pi-times" @click="closeDialog" class="p-button-text" />
            <Button label="Guardar" icon="pi pi-check"  @click="create_registry" />
        </template>
    </Dialog>

</template>