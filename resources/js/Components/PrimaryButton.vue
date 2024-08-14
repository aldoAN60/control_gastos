<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="
    inline-flex items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest focus:outline-none disabled:opacity-50 transition ease-in-out focus:ring-offset-2 duration-150
    bg-clear-custom-primary-100
    text-clear-custom-text
    hover:bg-clear-custom-primary-200 
    focus:bg-clear-custom-primary-200 
    active:bg-green-900 
    focus:ring-2 
    focus:ring-green-500 
    dark:bg-dark-custom-primary-100
    dark:text-dark-custom-text-100
    dark:hover:bg-dark-custom-primary-200 
    dark:focus:bg-dark-custom-primary-200 
    dark:active:bg-green-300 
    dark:focus:ring-offset-green-800
    ">
        <slot />
    </button>
</template>
