<script lang="ts" setup>
import Input from "@/Components/Input.vue";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import Marketing from "@/Layouts/Marketing.vue";
import {Recipe, Section} from "@/types";
import axios from "axios";
import {ref} from "vue";
import {Link, router, Head} from "@inertiajs/vue3";
import {debounce} from "@/Components/editor/util";

defineProps<{
    sections: Section[]
}>()

const showSearchResults = ref(false);
const query = ref('');
const searchResults = ref<Recipe[]>([]);
const search = (event: Event) => {
    const input = event.target as HTMLInputElement;
    query.value = input.value;

    axios.get(route('api.search', {query: query.value})).then((response) => {
        searchResults.value = response.data;
        showSearchResults.value = true;
    })
}
const onClickAway = () => {
    showSearchResults.value = false;
    searchResults.value = [];
}

const goToFirstResult = () => {
    if (searchResults.value.length > 0) {
        router.get(route('recipes.show', {recipe: searchResults.value[0].id}));
    }
}
</script>
<template>
    <Marketing>
        <Head title="Accueil">
            <meta name="description" content="Des recettes et des guides pour réduire son empreinte écologique"/>
        </Head>
        <div class="bg-gradient-to-b from-emerald-700 to-gray-50">

            <div class="w-full pt-16 pb-24 px-8 lg:px-0 lg:text-center container mx-auto">
                <h1 class=" text-2xl lg:text-4xl text-white font-bold leading-snug">
                    Des recettes et des guides pour réduire <br class="hidden lg:block"> son empreinte écologique
                </h1>

                <div class="relative max-w-lg mx-auto" v-if="$isClient">
                    <form @click="searchResults.length > 0 ? showSearchResults = true : null"
                          @submit.prevent="goToFirstResult" class="max-w-lg mt-8 mx-auto relative flex items-center">
                        <label class="sr-only" for="search">Rechercher</label>
                        <input
                            id="search"
                            class="transition w-full rounded-2xl text-white py-2.5 pl-6 pr-12 placeholder-white/80 hover:bg-brand-600 font-semibold border-none shadow-lg shadow-emerald-700/50 bg-emerald-700 focus:ring-brand-700 focus:ring-2"
                            autocomplete="off"
                            placeholder="Rechercher une recette, un guide..."
                            type="text"
                            name="search"
                            @input="debounce(() => search($event), 200)"
                        />
                        <MagnifyingGlassIcon
                            class="absolute w-5 h-5 text-white/60 right-6"
                        />
                    </form>

                    <div v-click-away="onClickAway" v-if="showSearchResults" class="absolute w-full">
                        <ul class="py-2 bg-white max-w-lg mx-auto mt-4 rounded-xl relative w-full shadow-xl text-left" v-if="searchResults.length > 0">
                            <li v-for="result in searchResults">
                                <Link :href="route('recipes.show', { recipe: result.slug.slug})"
                                      class="px-4 flex flex rounded-xl py-2 focus:ring-emerald-600 focus:ring focus:outline-none hover:bg-gray-100 transition ">
                                    <img :src="`/storage/${result.banner.pixel_path}`"
                                         :alt="result.banner.alt"
                                         :title="result.banner.alt"
                                         class="w-12 h-12 object-cover object-center rounded-xl float-left"/>

                                    <div class="ml-4">
                                        <span class="font-semibold block">{{ result.title }}</span>
                                        <p class="block text-gray-700 max-w-[21ch] sm:max-w-[calc(32rem-6rem)] truncate mt-0.5 pr-4 lg:pr-0">
                                            {{ result.description }}
                                        </p>
                                    </div>


                                </Link>
                            </li>
                        </ul>
                        <div v-else class="bg-white max-w-lg mt-4 rounded-xl relative w-full shadow-xl text-left">
                            <p class="text-gray-700 px-4 py-2">Aucun résultat pour « {{ query }} »</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-full py-8 container mx-auto space-y-16 lg:mt-6 px-8 lg:px-0">
            <section v-for="(section, k) in sections">
                <h2 class="text-3xl font-semibold">{{ section.title }}</h2>
                <p class="max-w-xl text-gray-700 mt-1">{{ section.description }}</p>

                <ul class="flex space-x-6 mt-4 flex-nowrap overflow-x-auto">
                    <li v-for="recipe in section.recipes" class="flex">
                        <Link :href="route('recipes.show', recipe.slug.slug)"
                           class="border w-72 lg:w-96 rounded-xl  flex-shrink-0 flex flex-col">
                            <img
                                :loading="k === 0 ? 'eager' : 'lazy'"
                                :src="`/storage/${recipe.banner.thumbnail_path}`" :alt="recipe.banner.alt"
                                class="object-top object-cover rounded-t-xl h-60 w-full"/>

                            <div class="p-4 bg-white rounded-b-xl border">
                                <h3 class="text-xl font-medium truncate">{{ recipe.short_title }}</h3>
                                <p class="text-gray-700 truncate">{{ recipe.description }}</p>
                            </div>
                        </Link>
                    </li>
                </ul>
            </section>
        </div>
    </Marketing>
</template>
