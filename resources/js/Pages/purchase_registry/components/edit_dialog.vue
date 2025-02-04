<template>
    <Dialog 
        :visible="dialogVisible" 
        @update:visible="(val) => emit('update:visible', val)"
        modal 
        header="Editar Registro" 
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
            <div class="field">
                <label for="tdc">Tarjeta de Crédito</label>
                <Dropdown 
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
                <Dropdown 
                    id="category" 
                    v-model="registry.category.id" 
                    :options="categoryOptions" 
                    optionLabel="name" 
                    optionValue="id"
                    placeholder="Selecciona una categoría"
                />
            </div>

            <!-- Subcategoría -->
            <div class="field">
                <label for="subCategory">Subcategoría</label>
                <Dropdown 
                    id="subCategory" 
                    v-model="registry.sub_category.id" 
                    :options="subCategoryOptions" 
                    optionLabel="name" 
                    optionValue="id"
                    placeholder="Selecciona una subcategoría"
                />
            </div>

            <!-- Método de Pago -->
            <div class="field">
                <label for="paymentMethod">Método de Pago</label>
                <Dropdown 
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
                <Dropdown 
                    id="spendType" 
                    v-model="registry.spend_type" 
                    :options="spendTypeOptions" 
                    placeholder="Selecciona el tipo de gasto"
                />
            </div>

            <!-- Fecha de Compra -->
            <div class="field">
                <label for="purchaseDate">Fecha de Compra</label>
                <Calendar 
                    id="purchaseDate" 
                    v-model="registry.formattedDate" 
                    dateFormat="dd/mm/yy"
                />
            </div>
        </div>

        <template #footer>
            <Button label="Cancelar" icon="pi pi-times" @click="closeDialog" class="p-button-text" />
            <Button label="Guardar" icon="pi pi-check" @click="saveChanges" />
        </template>
    </Dialog>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch } from "vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";

    const props = defineProps({
        visible: Boolean,
        selected_registry: Object,
    });

    const emit = defineEmits(["update:visible", "save"]);

    const dialogVisible = ref(props.visible);
    const registry = ref({ ...props.selected_registry });

    // Sincronizar estado con props
    watch(() => props.visible, (newVal) => {
        dialogVisible.value = newVal;
    });

    // Sincronizar el modelo
    watch(() => props.selected_registry, (newVal) => {
        registry.value = { ...newVal };
    });

    const closeDialog = () => {
        emit("update:visible", false);
    };

    const saveChanges = () => {
        emit("save", registry.value);
        closeDialog();
    };
</script>
