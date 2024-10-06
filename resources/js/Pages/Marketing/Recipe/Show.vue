<script lang="ts" setup>
import {Asset, Category, Prerequisite, Recipe} from "@/types";
import Marketing from "@/Layouts/Marketing.vue";
import {computed} from "vue";
import StarterKit from "@tiptap/starter-kit";
import LinkExtension from "@tiptap/extension-link";
import {Head, Link} from "@inertiajs/vue3";
import {generateHTML} from "@tiptap/html";

const props = defineProps<{
  recipe: Recipe & {
    banner: Asset,
    category: Category,
    prerequisites: (Prerequisite & {
      display_mode: string
    })[],
    illustrations: Asset[]
  },
}>()


const html = computed(() => generateHTML(JSON.parse(props.recipe.content), [
  StarterKit,
  LinkExtension
]))
</script>
<template>
  <Marketing>
    <Head :title="`${recipe.title} - ${recipe.category.name}`">
      <meta :content="`https://faireplusachetermoins.fr/storage/${recipe.banner.small_path}`" property="og:image"/>
      <meta :content="recipe.title" property="og:title"/>
      <meta :content="recipe.description" property="og:description"/>
      <meta content="article" property="og:type"/>

      <meta content="summary_large_image" property="twitter:card">
      <meta :content="recipe.title" property="twitter:title">
      <meta :content="recipe.description" property="twitter:description">
      <meta :content="`https://faireplusachetermoins.fr/storage/${recipe.banner.small_path}`" property="twitter:image">

      <meta :content="recipe.description" name="description"/>
    </Head>
    <div class="w-full pt-8 container px-8 lg:px-0 lg:mx-auto lg:mt-6">
      <div class="flex flex-col-reverse">
        <h1 class="font-semibold text-3xl lg:text-6xl my-12 text-center">
          {{ recipe.title }}
        </h1>
        <img

            :alt="recipe.banner.alt"
            :src="`/storage/${recipe.banner.small_path}`"
            :title="recipe.banner.alt"
            width="900"
            height="507"
            class="rounded-xl w-full h-auto lg:w-[900px] lg:h-[507px] object-top object-cover mx-auto"
        />
      </div>

    </div>

    <div class="flex flex-col lg:flex-row justify-center items-start px-8 xl:px-0 lg:space-x-8">
      <div class="max-w-sm w-full space-y-8">
        <div class="lg:bg-white lg:border lg:rounded-xl">
          <h2 class="text-xl lg:px-8 pt-4 pb-2 lg:pb-4 mb-2 lg:mb-0  lg:bg-gray-50 font-semibold border-b rounded-t-xl text-brand-700">
            Ingrédients</h2>

          <ul class="divide-y">
            <li v-for="prerequisite in recipe.prerequisites" class="lg:px-8 py-3">
              <div v-if="true || prerequisite.display_mode === 'NameDetailsThenQuantity'">
                                <span class="font-semibold text-lg">
                                   {{ prerequisite.prerequisite.title ?? prerequisite.prerequisite.name }}

                                    <span v-if="prerequisite.details" class="font-normal">
                                        ({{ prerequisite.details }})
                                    </span>

                                </span>
                <div v-if="prerequisite.optional" class="mt-1">
                  <span
                      class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Optionel</span>
                </div>
                <span class="block mt-1 text-lg">
                                {{ prerequisite.quantity }}
                                </span>
              </div>
              <div v-else-if="prerequisite.display_mode === 'QuantityNameThenDetails'">
                                <span class="font-semibold text-lg">
                                   {{
                                    prerequisite.quantity
                                  }} {{ (prerequisite.prerequisite.title ?? prerequisite.prerequisite.name) }}
                                </span>

                <span class="block text-lg">
                                    {{ prerequisite.details }}
                                </span>
              </div>
            </li>
          </ul>
        </div>

        <ul class="divide-y hidden lg:block">
          <li v-for="asset in recipe.illustrations" class="mt-8 first:mt-0 bg-white rounded-xl">
            <img
                :src="`/storage/${asset.small_path}`"
                :title="asset.alt"
                class="rounded-t-xl w-full h-48 object-cover object-center"
                loading="lazy"
            />
            <span class="block text-gray-900 px-4 py-2 rounded-b-xl border border-t-0">{{
                asset.alt
              }}</span>
          </li>
        </ul>
      </div>
      <div class="max-w-[calc(65ch+2rem)] w-full lg:mb-0 lb:pb-0 lg:bg-white lg:border lg:rounded-xl mt-8 lg:mt-0">
        <h2 class="text-xl font-semibold lg:px-8 pt-4 mb-2 pb-2 lg:mb-0 lg:pb-4 lg:bg-gray-50 border-b rounded-t-xl text-brand-700 ">
          Préparation <span v-if="recipe.time_to_prepare">: {{ recipe.time_to_prepare }}</span>
        </h2>

        <div class="prose prose-xl prose-emerald lg:px-8 prose-p:text-gray-900">
          <div v-if="recipe.uses_sterilization" class="not-prose mt-6 rounded-xl bg-amber-100 px-8 py-4">
                        <span class="font-bold lg:text-lg text-amber-900">
                            Avertissement : cette recette nécessite de la stérilisation
                        </span>

            <p>
              <Link :href="route('sterilization-warning')"
                    class="text-amber-900 font-medium underline text-base lg:text-lg">
                En savoir plus sur la stérilisation &rarr;
              </Link>
            </p>

          </div>
          <div class="!mt-0" v-html="html"></div>

          <div class="not-prose border-t my-8 pt-8">
            <div class="lg:flex clear-both">
              <img
                  alt=""
                  class="w-36 h-auto object-cover rounded-md object-left float-left lg:float-none mr-4 lg:mr-0"
                  loading="lazy"
                  src="/moman-portrait.webp"
                  width="144"
                  height="128"
              >

              <div class="lg:px-4">
                <h3 class="font-semibold text-xl">Charlotte Dorn</h3>
                <p class="max-w-lg text-base mt-1">
                  Journaliste depuis 1996, prof de journalisme, citoyenne engagée, je partage des
                  recettes et
                  des
                  guides
                  pour
                  faire plus soi-même et acheter moins tout fait. Le but : réduire son empreinte
                  écologique et
                  augmenter
                  son
                  autonomie.
                </p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </Marketing>
</template>
