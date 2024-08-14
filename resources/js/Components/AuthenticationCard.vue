<template>
        <div class="min-h-screen flex flex-row sm:justify-center items-center gap-4 pt-6 sm:pt-0 bg-clear-custom-bg-100 dark:bg-dark-custom-bg-100">
            <div class="flex flex-col items-center ">
                <div>
                    <slot name="logo" />
                </div>
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-clear-custom-bg-200 dark:bg-dark-custom-bg-200 shadow-md overflow-hidden sm:rounded-lg">
                    <slot />
                </div>
            </div>
        <div class=" flex flex-col items-center">
            <slot name="otros_registros" />

        </div>
    </div>
</template>
<!-- dark:text-dark-custom-text-100 -->