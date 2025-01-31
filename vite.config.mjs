import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/css/app.css",
                "resources/js/pages/section-index.js",
                "resources/js/components/sorter.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
