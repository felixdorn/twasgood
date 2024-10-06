<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import {router} from "@inertiajs/vue3";

defineProps<{
    tabs: {
        name: string,
        href: string,
        current: boolean
    }[]
}>()
</script>
<template>
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Sélectionnez un onglet</label>
            <select @change="router.visit($event.target.value)" id="tabs" name="tabs"
                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-xl">
                <option v-for="tab in tabs" :key="tab.name" :value="tab.href" :selected="tab.current">{{
                        tab.name
                    }}
                </option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <Link v-for="tab in tabs" :key="tab.name" :href="tab.href"
                                 :class="[tab.current ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']"
                                 :aria-current="tab.current ? 'page' : undefined">
                        {{ tab.name }}
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
