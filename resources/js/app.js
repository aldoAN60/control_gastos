import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css';
import { definePreset } from '@primevue/themes';
import ConfirmationService from 'primevue/confirmationservice';

import messageStore from "@/stores/messageStore";
import Aura from '@primevue/themes/aura';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const MyPreset = definePreset(Aura, {
    primitive: {
        indigo: { 50: '#fdf2f8', 100: '#fce7f3', 200: '#fbcfe8', 300: '#f9a8d4', 400: '#f472b6', 500: '#ec4899', 600: '#db2777', 700: '#be185d', 800: '#9d174d', 900: '#831843', 950: '#500724' },
        cpc: {
            50: '#0D6E6E',
            100: '#388C8C',
            150: '#4a9d9c',
            200: '#267E7D',
            250: '#afffff',
            300: '#7AC9C9',
        },
        csc: {
            100: '#ACD8D8',
            200: '#7FAAAA',
            300: '#547E7E',
            400: '#2B5455',
            450: '#4C7576',
            500: '#002E2F'
        },
        ctc: {
            100: '#f8fafc',
            200: '#f1f5f9',
            300: '#e2e8f0',
            400: '#cbd5e1',
            500: '#94a3b8',
            600: '#64748b',
            700: '#475569',
            800: '#334155',
            900: '#1e293b',
            950: '#0f172a',
            // 100: '#FFFFFF',
            // 200: '#e0e0e0'
        },
        cbc: {
            100: '#0D1F2D',
            150: '#354655',
            200: '#1d2e3d',
            250: '#425364',
            300: '#354656',
            350: '#576879'
        }
    },
    semantic: {
        primary: {
            50: '{cpc.50}',
            100: '{cpc.100}',
            150: '{cpc.150}',
            200: '{cpc.200}',
            250: '{cpc.250}',
            300: '{cpc.300}',
            
        },
        secondary: {
            100: '{csc.100}',
            200: '{csc.200}',
            300: '{csc.300}',
            400: '{csc.400}',
            450: '{csc.450}',
            500: '{csc.500}',
        },
        text: {
            100: '{ctc.100}',
            200: '{ctc.200}',
            300: '{ctc.300}',
            400: '{ctc.400}',
            500: '{ctc.500}',
            600: '{ctc.600}',
            700: '{ctc.700}',
            800: '{ctc.800}',
            900: '{ctc.900}',
            950: '{ctc.950}',
        },
        background: {
            100: '{cbc.100}',
            150: '{cbc.150}',
            200: '{cbc.200}',
            250: '{cbc.250}',
            300: '{cbc.300}',
            350: '{cbc.350}',
        },
    },
    components: {
        inputtext: {
            colorScheme: {
                light: {
                    root: {
                        background: '{primary.50}',
                        color: '{text.200}'
                    },
                },
                dark: {
                    root: {
                        background: '{background.100}',
                        color: '{text.200}'
                    },
                    border:{
                        color:'{background.150}',
                    },
                    hover:{
                        border:{
                            color:'{background.250}',
                        },
                    },
                    focus:{
                        border:{
                            color:'{background.350}',
                        },
                    },
                }
            }
        },
        select: {
            colorScheme: {
                light: {
                    root: {
                        background: '{primary.50}',
                        color: '{text.200}'
                    },
                },
                dark: {
                    root: {
                        background: '{background.100}',
                        color: '{text.200}',
                    },
                    overlay: {
                        background:'{background.300}',
                        color: '{text.200}',
                        border:{
                            color:'{background.350}',
                        },
                    },
                    border: {
                        color:'{background.150}',
                    },
                    hover: {
                        border: {
                            color:'{background.250}',
                        },
                    },
                    focus: {
                        border: {
                            color:'{background.350}',
                        },
                    },
                    option: {
                        focus: {
                            background: '{background.100}',
                        },
                        selected: {
                            background:'{background.200}',
                            focus: {
                                background: '{background.200}',
                            },
                        },
                    },
                }
            }
        },
        dialog:{
            background:'{background.200}',
            border:{
                color:'{background.250}',
            },
        },
        button:{
            colorScheme: {
                light: {
                    root: {
                        background: '{primary.50}',
                        color: '{text.200}'
                    },
                },
                dark:{
                    primary:{
                        background:'{primary.100}',
                        color:'{text.100}',
                        hover:{
                            background:'{primary.150}',
                            border:{
                                color:'{primary.200}',
                            },
                            color:'{text.100}',
                        },
                        active:{
                            background:'{primary.200}',
                            color:'{text.100}',
                        },
                        border:{
                            color:'{primary.50}',
                        },
                    },
                    secondary:{
                        background:'{secondary.400}',
                        color:'{text.100}',
                        hover:{
                            background: '{secondary.300}',
                            color:'{text.100}',
                            border:{
                                color:'{secondary.400}',
                            },
                        },
                        active:{
                            background:'{secondary.450}',
                            color:'{text.100}',
                            border:{
                                color:'{secondary.400}',
                            },
                        },
                        border:{
                            color:'{secondary.500}',
                        },
                    },
                    text:{
                        secondary:{
                            hover:{
                                background: '{background.150}',
                            },
                            active: {
                                background: '{background.250}',
                            },
                        },
                    },
                },
            
        },
        },
        card:{
            background:'{background.150}',

        }
    },
    
});
const localeSpanish = {
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        dayNamesMin: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],


};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: MyPreset,
                    
                },
                locale: localeSpanish
            })
            .use(ZiggyVue)
            .use(ConfirmationService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
