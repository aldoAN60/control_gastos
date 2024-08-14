<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';

import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import MenuLayout from '@/Components/MenuLayout.vue';
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

                    <!-- Responsive Settings Options -->
                </div>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-dark-custom-bg-200 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
