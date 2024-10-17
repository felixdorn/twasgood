<script setup lang="ts">
import { Link} from "@inertiajs/vue3";
import type { Component} from "vue";

withDefaults(defineProps<{
    href?: string;
    icon: Component;
    disabled?: boolean
}>(), {
    disabled: false
})
</script>
<template>
    <component :is="href ? Link : 'button'" v-bind="$attrs" :href="href" class="transition ease-in duration-150 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500" :class="disabled ? 'pointer-events-none cursor-not-allowed opacity-50':''">
        <component :is="icon" v-if="icon" class="-ml-1 mr-3 h-5 w-5" aria-hidden="true" />
        <slot />
    </component>
</template>
