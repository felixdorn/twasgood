<template>
    <Link :href="`/recettes/${recipe.slug.slug}`"
          class="flex flex-col rounded-xl shadow-lg max-w-lg w-full bg-white">
        <img
           :loading="lazy ? 'lazy' : 'eager'"
            :src="`/storage/${recipe.banner.thumbnail_path}`"
            :alt="recipe.banner.alt"
            class="w-full rounded-t-xl"
        />
        <div class="flex flex-col flex-1 px-6 py-4">
            <h2 class="text-xl font-semibold">{{ recipe.title }}</h2>
            <p class="text-gray-500 mt-1">{{ recipe.description }}</p>
        </div>
    </Link>
</template>
<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import {Recipe} from "@/types";

defineProps<{
    recipe: Recipe,
    lazy: boolean
}>()
</script>
