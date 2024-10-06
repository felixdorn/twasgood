<script lang="ts" setup>
import {NodeViewWrapper} from "@tiptap/vue-3";
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {Recipe} from "@/types";
import {DraggableIcon} from "@/Components/editor/icons";
import draggable from "vuedraggable";
import {PlusIcon, XMarkIcon} from "@heroicons/vue/20/solid";
import ModelSearch from "@/Components/ModelSearch.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    node: {
        type: Object,
        required: true
    },
    editor: {
        type: Object,
        required: true
    },
    updateAttributes: {
        type: Function,
        required: true,
    }
})

const recipes = ref([])

axios.get('/api/recipes/by-ids', {
    params: {
        ids: props.node.attrs.recipes.map((recipe: Recipe) => recipe.id)
    }
}).then((response) => {
    recipes.value = props.node.attrs.recipes.map((recipe: { id: number, order: number }) => {
        return {
            order: recipe.order,
            ...response.data.filter((r: Recipe) => r.id === recipe.id)[0]
        }
    })
}).catch(err => console.error(err))

const allRecipes = ref([])
axios.get('/api/recipes').then((response) => {
    allRecipes.value = response.data
}).catch(err => console.error(err))

const addedRecipe = ref(null)
const insertRecipe = () => {
    if (addedRecipe.value) {
        embedRecipes.value = [...embedRecipes.value, addedRecipe.value]
        addedRecipe.value = null
    }
}
const removeEmbedRecipe = (index: number) => {
    embedRecipes.value = embedRecipes.value.filter((_, i) => i !== index);
}

const recipeBuf = computed(() => recipes.value)
const embedRecipes = computed({
    get: () => recipeBuf.value,
    set: (v) => {
        props.updateAttributes({
            recipes: v.map((recipe: Recipe, index: number) => {
                return {
                    id: recipe.id,
                    order: index
                }
            })
        })

        // Happy thoughts
        recipes.value = v
    }
})
</script>
<template>
    <node-view-wrapper>
        <div v-if="node.attrs.type === 'recipe-list'" class="not-prose">
            <draggable
                v-if="embedRecipes.length"
                v-model="embedRecipes"
                class="mt-1.5"
                ghost-class="bg-gray-100"
                item-key="order"
                tag="ul"
            >
                <template #item="{ element, index }">
                    <div
                        class="px-4 py-2.5 flex items-center justify-between select-none first:rounded-t-lg border border-t-0 first:border-t last:border-b-0 border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <DraggableIcon class="w-6 h-6 text-gray-500 cursor-move"/>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg">{{ element.title }}</h4>
                                <p class="text-gray-700 max-w-sm truncate">{{ element.description }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="text-gray-500 p-2 -m-2 hover:bg-gray-50 rounded-xl hover:text-gray-700"
                                    @click="removeEmbedRecipe(index)">
                                <XMarkIcon class="w-5 h-5"/>
                            </button>
                        </div>
                    </div>
                </template>
            </draggable>
            <div v-else>
                <div class="px-4 py-2.5 select-none border-x border-t rounded-t-lg">
                    <p class="text-gray-700">Aucune recette ajoutée.</p>
                </div>
            </div>
            <form @submit.prevent="insertRecipe" class="border flex justify-between bg-gray-50 items-end  rounded-b-md px-6 py-4">
                <ModelSearch v-model="addedRecipe"
                             :first="true"
                             :models="allRecipes"
                             class="w-full"
                             label="Ajouter une recette"
                             placeholder="Tarte aux pommes"
                             search-property="title"/>

                <SecondaryButton type="submit" :icon="PlusIcon" class="ml-4">
                    Ajouter
                </SecondaryButton>
            </form>
        </div>
        <div v-else class="border px-4 py-1">
            Erreur: type d'intégration non supporté: {{ node.attrs.type }}
        </div>

    </node-view-wrapper>
</template>

