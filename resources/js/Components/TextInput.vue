<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="border-emerald-300 dark:border-emerald-700 dark:bg-dark-custom-primary-100 text-clear-custom-text dark:text-dark-custom-text-200
        focus:border-emerald-500 
        dark:focus:border-teal-500 
        focus:ring-teal-500 
        dark:focus:ring-teal-600 
        rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>