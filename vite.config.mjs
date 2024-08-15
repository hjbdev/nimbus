import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: 'resources/dist/vendor/nimbus',
            input: ['resources/assets/nimbus.js'],
        }),
    ],
    build: {
        outDir: "resources/dist",
    }
});