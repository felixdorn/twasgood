import "./bootstrap";
import { createApp, DefineComponent, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "./routes.m";
import { modal } from "momentum-modal";
import VueClickAwayPlugin from "vue3-click-away";
import MasonryWall from "@yeger/vue-masonry-wall";

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
            .use(ZiggyVue, Ziggy)
            .use(MasonryWall)
            .use(VueClickAwayPlugin);

        app.config.globalProperties.$isClient = true;

        return app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
