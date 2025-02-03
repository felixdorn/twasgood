import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/css/app.css",
                "resources/js/components/sorter.js",
                "resources/js/components/field-autosizing.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
