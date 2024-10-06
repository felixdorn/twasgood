<script lang="ts" setup>
import Connected from "@/Layouts/Connected.vue";
import type {Asset, Diagnosis, Recipe, Tag} from "@/types";
import EmptyState from "@/Components/EmptyState.vue";
import {ClipboardDocumentIcon, PhotoIcon} from "@heroicons/vue/24/outline"
import Input from "@/Components/Input.vue";
import axios from "axios";
import {ref} from "vue";
import Button from "@/Components/Button.vue";
import {debounce} from "@/Components/editor/util";
import {useSync} from "@/sync";

const props = defineProps<{
    diagnoses: (Diagnosis & { recipe: Recipe & { tags: Tag[], illustrations: Asset[] } })[],
    /*{
        total: number,
        current_page: number,
        data:
        first_page_url: string,
        last_page_url: string,
        from: number,
        to: number,
        last_page: number,
        links: {
            url: string | null,
            label: string,
            active: boolean
        }[],
        path: string,
        per_page: number,
        prev_page_url: string | null,
    },*/

    // things needed by the diagnoses
    typeTags: Tag[],
    seasonTags: Tag[],
    hotColdTags: Tag[],
}>()

const done = ref<boolean>(false)

const toggleTag = async (event, diagnosis: Diagnosis & { recipe: Recipe }, retries: number = 5) => {
    const el = event.target.nodeName === 'LI' ? event.target : event.target.parentNode
    const checkbox = el.firstChild

    checkbox.checked = !checkbox.checked

    try {
        await axios.post(route('console.recipes.tags.toggle', {
            recipe: diagnosis.recipe.id,
            tag: checkbox.value
        }))
    } catch (e) {
        console.error(e)

        setTimeout(() => toggleTag(event, diagnosis, retries - 1), retries * 1000)
        return
    }
}

const completeDiagnosis = async (diagnosis: Diagnosis) => {
    await axios.post(route('console.diagnoses.complete', diagnosis.id), {});

    // add complete = true to the diagnosis
    diagnosis.complete = true
}

</script>
<template>
    <Connected title="Diagnostic">
        <EmptyState
            v-if="diagnoses.length === 0"
            :icon="ClipboardDocumentIcon"
            class="text-center mt-6"
            description="Aucun problème n'a été détecté sur l'ensemble des articles."
            title="Aucun problème détecté"
        />
        <div v-else class="mt-4 space-y-4 xl:space-y-0 xl:gap-8 grid xl:grid-cols-2">
            <div v-for="diagnosis in diagnoses">
                <div v-if="diagnosis.complete"
                     class="h-60 bg-gray-50 border  rounded-xl flex items-center justify-center">
                    <h2 class="text-xl font-semibold text-gray-700 max-w-lg text-center">
                        {{ `Le problème de la recette "${diagnosis.recipe.title}" est résolu.` }}</h2>
                </div>
                <div v-else class="border rounded-xl">
                    <div v-if="diagnosis.type === 'no_tag' || diagnosis.type === 'initial_maybe_add_season' || diagnosis.type === 'no_hot_cold_tag'" class="bg-white rounded-xl p-6">
                        <span class="text-sm text-gray-700">Recommandation</span>
                        <h3 class="text-xl -mt-0.5">
                            <span class="font-semibold">{{ diagnosis.recipe.title }}</span>
                            devrait peut-être avoir {{ {
                                'no_tag': 'un tag',
                                'initial_maybe_add_season': 'une saison',
                                'no_hot_cold_tag': 'un tag chaud ou/et froid',
                            }[diagnosis.type] }}.
                        </h3>

                        <ul class="flex flex-wrap gap-x-4 gap-y-3 mt-4">
                            <li v-for="tag in {
                                'no_tag': typeTags,
                                'initial_maybe_add_season': seasonTags,
                                'no_hot_cold_tag': hotColdTags,
                            }[diagnosis.type]"
                                class="cursor-pointer bg-gray-100 inline-flex px-6 py-4 rounded-xl text-sm font-medium text-gray-800 items-center justify-between"
                                @click="toggleTag($event, diagnosis)">
                                <input
                                    :checked="diagnosis.recipe.tags.find(t => t.id === tag.id)"
                                    :value="tag.id"
                                    class="h-4 w-4 pointer-events-none rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                                    type="checkbox"/>
                                <span class="ml-4 select-none text-lg">{{
                                        {
                                            'no_tag': tag.name,
                                            'initial_maybe_add_season': {
                                                'all': 'Toutes saisons',
                                                'spring': 'Printemps',
                                                'summer': 'Été',
                                                'autumn': 'Automne',
                                                'winter': 'Hiver',
                                            }[tag.name],
                                            'no_hot_cold_tag': tag.name
                                        }[diagnosis.type]
                                    }}</span>
                            </li>
                        </ul>

                        <form class="flex" @submit.prevent="completeDiagnosis(diagnosis)">
                            <button class="border py-2 px-4 rounded-xl mt-6 flex items-center hover:bg-gray-50">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.602 13.7599L13.014 15.1719L21.4795 6.7063L22.8938 8.12051L13.014 18.0003L6.65 11.6363L8.06421 10.2221L10.189 12.3469L11.6025 13.7594L11.602 13.7599ZM11.6037 10.9322L16.5563 5.97949L17.9666 7.38977L13.014 12.3424L11.6037 10.9322ZM8.77698 16.5873L7.36396 18.0003L1 11.6363L2.41421 10.2221L3.82723 11.6352L3.82604 11.6363L8.77698 16.5873Z"></path>
                                </svg>

                                <span class="ml-2">Marquer comme terminé / ignoré</span>
                            </button>
                        </form>
                    </div>
                    <div v-else class="mt-2">
                        Erreur: {{ diagnosis.type }} n'est pas implementé.
                    </div>
                </div>
            </div>
        </div>
    </Connected>
</template>
