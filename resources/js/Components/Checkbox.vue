<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <input
        v-model="proxyChecked"
        type="checkbox"
        :value="value"
        class="
        rounded shadow-sm
        dark:bg-dark-custom-primary-100
        border-teal-300 
        dark:border-teal-700 
        text-teal-600
        focus:ring-teal-500 
        dark:focus:ring-teal-600 
        dark:focus:ring-offset-teal-800
        "
    >
</template>

