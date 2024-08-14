<script setup>
import { Head, Link } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Bienvenido" />
    <header class="grid grid-cols-2 px-5">
        <div class="">
            <section class=" bg-red-500 w-32 h-14 flex flex-col justify-center items-center" >
                <h2 class="text-xl font-bold tracking-widest">logo</h2>
            </section>
        </div>
        <div class="flex flex-row justify-end items-center" >
            <section class="flex gap-x-4 font-semibold text-lg ">
                
                <Link :href="route('login')" class="dark:text-dark-custom-text-100" >
                    Iniciar sesion
                </Link>
                <Link :href="route('register')" class="dark:text-dark-custom-text-200" >
                    Registrarse
                </Link>
                
            </section>
        </div>
    </header>

    <main class="min-h-screen  grid grid-cols-2 px-5">
        <div class="flex flex-col justify-center items-center" >
            <section>
                <h1 class="text-3xl font-bold dark:text-dark-custom-text-100" >controla tus gastos y mejora tus finanzas</h1>
            </section>
        </div>
        <div  class="flex flex-col justify-center items-center">
            <section>
                <div class="w-96 h-96 bg-blue-500">
                    <span>una imagen</span>
                </div>
            </section>
        </div>

    </main>

</template>
