import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, DefineComponent, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import PrimeVue from "primevue/config"
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice'
import InputText from "primevue/inputtext";
import Textarea from 'primevue/textarea'
import Select from "primevue/select"
import Button from "primevue/button"
import Editor from "primevue/editor"
import Checkbox from 'primevue/checkbox';
import FileUpload from "primevue/fileupload";
import DatePicker from "primevue/datepicker";
import Aura from "@primevue/themes/aura"

const appName = 'The Cove Pub'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: 'none',
                    }
                }
            })
            .use(ToastService)
            .component('Toast', Toast)
            .component('Textarea', Textarea)
            .component('Select', Select)
            .component('InputText', InputText)
            .component('Button', Button)
            .component('Editor', Editor)
            .component('FileUpload', FileUpload)
            .component('Checkbox', Checkbox)
            .component('DatePicker', DatePicker)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
