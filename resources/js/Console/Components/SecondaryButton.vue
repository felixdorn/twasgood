<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";

defineProps<{
    href?: string;
}>();
</script>
<template>
    <component :is="href ? Link : 'button'" :href="href"
        class="inline-flex items-center py-2 px-4 text-sm font-medium leading-4 text-gray-700 bg-white rounded-xl border transition duration-150 ease-in focus:ring-2 focus:ring-offset-2 focus:outline-none hover:text-brand-700 focus:ring-brand-500">
        <slot />
    </component>
</template>
