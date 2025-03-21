<template>
    <div>
        <Toast v-if="show" :severity="severity" :summary="summary" :detail="detail" :group="group" :closable="closable" :life="life" />
    </div>
</template>

<script setup>
import { useToast } from "primevue/usetoast";
const toast = useToast();
import { defineProps, watch } from 'vue';


const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    severity: {
        type: String,
        default: "info"
    },
    summary: {
        type: String,
        required: true,
    },
    detail: {
        type: String,
        required: true,
    },
    group: {
        type: String,
        default: "tl"
    },
    closable: {
        type: Boolean,
        default: false,
    },
    life: {
        type: Number,
        default: 3000,
    }
});

// Revisar cuando el prop 'show' cambie
watch(() => props.show, (newVal) => {
    console.log('show prop changed:', newVal);
    if (newVal) {
        showToast();
    }
});

const showToast = () => {
    toast.add({
        severity: props.severity,
        summary: props.summary,
        detail: props.detail,
        group: props.group,
        closable: props.closable,
        life: props.life
    });
};
</script>
