<script lang="ts" setup>
import Connected from "@/Console/Layouts/Connected.vue";
import type {Category} from "@/Console/types";
import {DocumentMagnifyingGlassIcon, DocumentPlusIcon} from "@heroicons/vue/24/outline";
import Button from "@/Console/Components/Button.vue";
import {Link} from "@inertiajs/vue3";
import EmptyState from "@/Console/Components/EmptyState.vue";

const props = defineProps<{
    categories: (Category & { deletable: boolean })[],
}>()
</script>
<template>
    <Connected title="Catégories">
        <template #header>
            <Link :href="route('console.categories.create')" :preserve-state="true" :preserve-scroll="true"
                  :only="['modal']">
                <Button :icon="DocumentPlusIcon">Nouvelle catégorie</Button>
            </Link>
        </template>

        <ul v-if="categories.length > 0" class="grid grid-cols-2 xl:grid-cols-3 gap-4 mt-6">
            <li v-for="category in categories">
                <Link

                    :preserve-state="true"
                    :preserve-scoll="true"
                    :only="['modal']"
                    :href="route('console.categories.edit', { category: category.id, })"
                    class="group flex flex-col border rounded-xl bg-white py-4 px-6">

                    <span class="text-lg group-hover:underline">{{ category.name }}</span>
                    <span class="text-gray-500">{{ category.recipes_count }} au total</span>
                </Link>
            </li>
        </ul>

        <EmptyState
            v-else
            :action-href="route('console.categories.create')"
            :action-icon="DocumentPlusIcon"
            :icon="DocumentMagnifyingGlassIcon"
            action-title="Nouvelle catégorie"
            class="text-center mt-6"
            description="Vos catégories s'afficheront ici, une fois créés."
            title="Aucune catégorie"
        />
    </Connected>
</template>
