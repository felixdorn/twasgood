<script lang="ts" setup>
import Connected from "@/Console/Layouts/Connected.vue";
import Button from "@/Console/Components/Button.vue";
import {
    DocumentMagnifyingGlassIcon,
    DocumentPlusIcon,
} from "@heroicons/vue/24/outline";
import type { Recipe } from "@/Console/types";
import { Link } from "@inertiajs/vue3";
import Tab from "@/Console/Components/Tab.vue";
import EmptyState from "@/Console/Components/EmptyState.vue";

const enum PublicationState {
    Published = "published",
    Unpublished = "unpublished",
}

let props = defineProps<{
    recipes: Recipe[];
    state: PublicationState;
    published_count: number;
    unpublished_count: number;
}>();

const tabs = [
    {
        name: `Publiés (${props.published_count})`,
        href: route("console.recipes.index", {
            state: PublicationState.Published,
        }),
        current: props.state === PublicationState.Published,
    },
    {
        name: `Brouillons (${props.unpublished_count})`,
        href: route("console.recipes.index", {
            state: PublicationState.Unpublished,
        }),
        current: props.state === PublicationState.Unpublished,
    },
];
</script>
<template>
    <Connected title="Recettes">
        <template #header>
            <Link :href="route('console.recipes.create')" :preserve-scroll="true" :preserve-state="true"
                :only="['modal']">
            <Button :icon="DocumentPlusIcon"> Créer une recette </Button>
            </Link>
        </template>

        <Tab :tabs="tabs" class="mt-4 sm:mt-0" />

        <div v-if="recipes.length > 0" :gap="16" :items="recipes" :min-columns="3" class="mt-6 w-full -m-4 columns-3 xl:columns-4 gap-x-4">
                <Link :href="route('console.recipes.edit', { recipe: item.id })"
                v-for="item in recipes"
                    class="group block border rounded-xl bg-white h-fit break-inside-avoid mb-4">
                <img v-if="item.banner?.url" loading="lazy" :src="item.banner.url" class="rounded-t-xl" height="507"
                    width="907" />
                <div v-else
                    class="bg-gray-50 border-b flex items-center justify-center text-sm rounded-t-xl text-gray-700 h-40">
                    Pas d'aperçu disponible
                </div>
                <div class="px-5 py-3">
                    <h3 class="md:flex items-center justify-between">
                        <span class="text-lg group-hover:underline">{{
                            item.title
                        }}</span>
                    </h3>

                    <span v-if="item.description.length > 255"
                        class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Description trop longue (> 255 caractères)
                    </span>
                    <p v-if="item.description" class="text-gray-700 max-w-xl mt-2 truncate">
                        {{ item.description }}
                    </p>
                </div>
                </Link>
        </div>
        <EmptyState v-else :action-href="route('console.recipes.create')" :action-icon="DocumentPlusIcon"
            :icon="DocumentMagnifyingGlassIcon" action-title="Nouveau brouillon" class="text-center mt-6"
            description="Vos recettes s'afficheront ici une fois publiées. Commencez par créer un brouillon."
            title="Aucune recette" />

        <div ref="triggerTarget" class="h-36 w-full -mt-36"></div>
    </Connected>
</template>
