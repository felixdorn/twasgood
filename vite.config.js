import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.ts",
                "resources/css/app.css",
                "resources/js/pages/section-index.ts",
            ],
            refresh: true,
        }),
    ],
});
