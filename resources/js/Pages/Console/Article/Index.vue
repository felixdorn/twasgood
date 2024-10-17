<script lang="ts" setup>
import Connected from "@/Layouts/Connected.vue";
import Button from "@/Components/Button.vue";
import {
    DocumentMagnifyingGlassIcon,
    DocumentPlusIcon,
} from "@heroicons/vue/24/outline";
import type { Article } from "@/types";
import { Link } from "@inertiajs/vue3";
import Tab from "@/Components/Tab.vue";
import EmptyState from "@/Components/EmptyState.vue";
import { useIntersectionObserver } from "@vueuse/core";
import { ref } from "vue";
import axios from "axios";

const enum PublicationState {
    Published = "published",
    Unpublished = "unpublished",
}

let props = defineProps<{
    articles: Article[];
    state: PublicationState;
    published_count: number;
    unpublished_count: number;
}>();

const tabs = [
    {
        name: `Publiés (${props.published_count})`,
        href: route("console.articles.index", {
            state: PublicationState.Published,
        }),
        current: props.state === PublicationState.Published,
    },
    {
        name: `Brouillons (${props.unpublished_count})`,
        href: route("console.articles.index", {
            state: PublicationState.Unpublished,
        }),
        current: props.state === PublicationState.Unpublished,
    },
];
</script>
<template>
    <Connected title="Articles">
        <template #header>
            <Button :href="route('console.articles.create')" :icon="DocumentPlusIcon">Créer un article</Button>
        </template>

        <Tab :tabs="tabs" class="mt-4 sm:mt-0" />

        <masonry-wall v-if="articles.length > 0" :gap="16" :items="articles" :min-columns="3" class="mt-6 w-full -m-4">
            <template #default="{ item, index }: { item: Article; index: number }">
                <Link :href="route('console.articles.edit', { article: item.id })"
                    class="group block border rounded-xl bg-white h-fit">
                <img v-if="
                    item.banner &&
                    item.banner.path !== 'uploads/thumbnails/'
                " loading="lazy" :src="item.banner.url" class="rounded-t-xl" height="507" width="907" />
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
            </template>
        </masonry-wall>
        <EmptyState v-else :action-href="route('console.articles.create')" :action-icon="DocumentPlusIcon"
            :icon="DocumentMagnifyingGlassIcon" action-title="Nouveau brouillon" class="text-center mt-6"
            description="Vos articles s'afficheront ici une fois publiées. Commencez par créer un brouillon."
            title="Aucune article" />

        <div ref="triggerTarget" class="h-36 w-full -mt-36"></div>
    </Connected>
</template>
