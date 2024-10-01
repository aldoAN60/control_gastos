<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import messageStore from '@/stores/messageStore';

//componentes personalizados
// componenetes de primeVue
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import MenuLayout from '@/Components/MenuLayout.vue';
import Message from 'primevue/message';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);


const nombre = 'Aldo Armenta'

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-dark-custom-bg-100">
                <!-- Primary Navigation Menu -->
                <MenuLayout>
                    <template v-slot:nombre_usuario>
                    {{ nombre }}
                    </template>
                </MenuLayout>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>
                </div>
                <section v-if="messageStore.mensaje_visible.value">
                    <Message :severity="messageStore.severity.value" :life="3000" :key="messageStore.messageKey.value">
                    {{ messageStore.mensaje.value }}
                    </Message>
                </section>
            <!-- Page Heading -->
            <header class="bg-white dark:bg-dark-custom-bg-200 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <slot name="header" />
                    </h2>
                </div>
            </header>
            
            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="dark:text-dark-custom-text-100 p-3">
                            <slot name="main_content"/>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
