<script lang="ts" setup>
import {Asset, Category, Recipe} from "@/types";
import Marketing from "@/Layouts/Marketing.vue";
import {Head, router} from "@inertiajs/vue3"
import RecipeCard from "@/Pages/Marketing/Category/RecipeCard.vue";

const props = defineProps<{
  category: Category & { recipes: (Recipe & { banner: Asset, slug: string })[] },
  filters: {
    label: string,
    value: string,
    disabled: boolean,
    active: boolean
  }[],
  duration: string
}>()

const toggleFilter = (filter) => {
  const currentUrl = new URL(window.location.href)

  // On ajoute ou retire le filtre "filter.label" de l'URL
  if (filter.active) {
    currentUrl.searchParams.delete(filter.value)
  } else {
    currentUrl.searchParams.set(filter.value, 'yes')
  }

  props.filters.forEach((filter) => {
    filter.active = currentUrl.searchParams.has(filter.value)
  })

  // On redirige vers la nouvelle URL
  router.get(currentUrl.toString())
}
</script>
<template>
  <Marketing>
    <Head :title="`${category.name}${category.subtitle ? ': ' + category.subtitle : ''}`"/>
    <div class="w-full py-8 container px-8 lg:px-0 mx-auto">
      <h1 class="font-semibold w-fit text-4xl">{{ category.name }}
        <span v-if="category.subtitle">: {{ category.subtitle }}</span>
      </h1>

      <p v-if="category.description" class="max-w-prose text-lg text-gray-700 mt-3">{{ category.description }}</p>


      <div v-if="$isClient && filters.length > 0" class="mt-8">
        <h3 class="text-lg font-semibold">Filtres</h3>
        <p class="mt-1 text-gray-700">
          Pour filtrer les recettes, cliquez sur les filtres ci-dessous.
        </p>
        <div class="mt-2">
          <ul class="flex space-x-4 flex-nowrap overflow-x-scroll">
            <li v-for="filter in filters" class="">
              <button
                  :class="[filter.active ? 'border-brand-600 bg-brand-600 text-white font-semibold hover:bg-brand-500' : 'bg-white hover:bg-gray-50']"
                  class="border px-4 py-2 rounded-full mt-1 whitespace-nowrap"
                  type="button"
                  @click="toggleFilter(filter)">
                {{ filter.label }}
              </button>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-8">
        <h3 class="text-lg font-semibold">Résultats</h3>
        <p class="mt-1 text-gray-700">
          {{ category.recipes.length }} recette{{ category.recipes.length === 1 ? '' : 's' }}
          trouvée{{ category.recipes.length === 1 ? '' : 's' }} en {{ duration }}ms.

        </p>
      </div>

      <masonry-wall v-if="$isClient" :key="category.id" :gap="32" :items="category.recipes" class="mt-6">
        <template #default="{ item, index }: { item: Recipe  & { banner: Asset, slug: string } }">
          <RecipeCard :lazy="index <= 3" :key="item.id" :recipe="item"/>
        </template>
      </masonry-wall>
      <div v-else class="mt-6 grid grid-cols-2 gap-4">
        <RecipeCard v-for="recipe in category.recipes" :key="recipe.id" :recipe="recipe"/>
      </div>
    </div>
  </Marketing>
</template>
