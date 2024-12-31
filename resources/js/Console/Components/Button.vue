<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

withDefaults(
    defineProps<{
        href?: string;
        disabled?: boolean;
    }>(),
    {
        disabled: false,
    },
);
</script>
<template>
    <component :is="href ? Link : 'button'" v-bind="$attrs" :href="href"
        class="inline-flex items-center py-2 px-4 text-sm font-medium leading-4 text-white border border-transparent shadow-sm transition ease-in focus:ring-2 focus:ring-offset-2 focus:outline-none bg-brand-600 hover:bg-brand-700 focus:ring-brand-500"
        :class="disabled
                ? 'pointer-events-none cursor-not-allowed opacity-50 grayscale'
                : ''
            ">
        <slot />
    </component>
</template>
