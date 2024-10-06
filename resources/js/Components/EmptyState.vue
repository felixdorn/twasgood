<script lang="ts" setup>
import Button from "@/Components/Button.vue";
import type { Component} from "vue";

defineProps<{
    icon: Component,
    title: string,
    description: string,
    actionTitle?: string,
    actionIcon?: Component,
    actionHref?: string,
}>()
</script>
<template>
    <div class="bg-white rounded-xl py-8">
        <component :is="icon" class="mx-auto h-12 w-12 text-gray-400" />
        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ title }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ description }}</p>
        <div class="mt-6" v-if="actionTitle">
            <Button :href="actionHref" :icon="actionIcon">{{ actionTitle }}</Button>
        </div>
    </div>
</template>
