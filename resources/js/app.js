import './bootstrap';
import '../css/app.css';
import 'preline';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { HSStaticMethods } from 'preline';
HSStaticMethods.autoInit(); 

const pages = import.meta.glob('./pages/**/*.vue')

createInertiaApp({
  resolve: name => {
    const page = pages[`./pages/${name}.vue`]
    if (!page) throw new Error(`Page not found: ${name}`)
    return page()
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
