import { createApp, h } from "vue";
import { Link, createInertiaApp } from "@inertiajs/vue3";
import MainLayout from "./Layouts/MainLayout.vue";
import { ZiggyVue } from "ziggy";
import "../css/app.css";

createInertiaApp({
    // Using inertia persistent layout
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    // resolve: name => {
    //   const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    //   return pages[`./Pages/${name}.vue`]
    // },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,
    
        // The color of the progress bar...
        color: '#29d',
    
        // Whether to include the default NProgress styles...
        includeCSS: true,
    
        // Whether the NProgress spinner will be shown...
        showSpinner: true,
      },
});
