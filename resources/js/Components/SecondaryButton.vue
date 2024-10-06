<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import type {Component} from "vue";

defineProps<{
    href?: string;
    icon: Component;
}>()
</script>
<template>

    <component :is="href ? Link : 'button'" :href="href"
               class="transition ease-in duration-150 inline-flex items-center px-4 py-2 border text-sm leading-4 font-medium rounded-xl text-gray-700 bg-white hover:text-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
        <component :is="icon" v-if="icon" aria-hidden="true" class="-ml-1 mr-3 h-5 w-5"/>
        <slot/>
    </component>
</template>
