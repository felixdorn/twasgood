import "./../bootstrap";
import { createApp, DefineComponent, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "./routes.m";
import { modal } from "momentum-modal";

createInertiaApp({
    title: (title) => `${title} - Faire + Acheter -`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(modal, {
                resolve: (name) =>
                    resolvePageComponent(
                        `./Pages/${name}.vue`,
                        import.meta.glob<DefineComponent>("./Pages/**/*.vue"),
                    ),
            })
            .use(plugin)
            .use(ZiggyVue, Ziggy);

        return app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
