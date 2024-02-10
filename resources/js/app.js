import { createApp, h } from 'vue'
import { Link, createInertiaApp } from '@inertiajs/vue3'
import MainLayout from "./Layouts/MainLayout.vue";

createInertiaApp({
  // Using inertia persistent layout
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || MainLayout
    return page
  },
  // resolve: name => {
  //   const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
  //   return pages[`./Pages/${name}.vue`]
  // },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link', Link)
      .mount(el)
  },
})
