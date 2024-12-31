<script lang="ts" setup>
import { NodeViewWrapper } from "@tiptap/vue-3";
import { computed, onMounted, ref } from "vue";
import axios from "axios";
import { Recipe } from "@/Console/types";
import { DraggableIcon } from "@/Console/Components/editor/icons";
import draggable from "vuedraggable";
import { PlusIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import ModelSearch from "@/Console/Components/ModelSearch.vue";
import SecondaryButton from "@/Console/Components/SecondaryButton.vue";

const props = defineProps({
    node: {
        type: Object,
        required: true,
    },
    editor: {
        type: Object,
        required: true,
    },
    updateAttributes: {
        type: Function,
        required: true,
    },
});

const recipes = ref([]);

axios
    .get("/api/recipes/by-ids", {
        params: {
            ids: props.node.attrs.recipes.map((recipe: Recipe) => recipe.id),
        },
    })
    .then((response) => {
        recipes.value = props.node.attrs.recipes.map(
            (recipe: { id: number; order: number }) => {
                return {
                    order: recipe.order,
                    ...response.data.filter(
                        (r: Recipe) => r.id === recipe.id,
                    )[0],
                };
            },
        );
    })
    .catch((err) => console.error(err));

const allRecipes = ref([]);
axios
    .get("/api/recipes")
    .then((response) => {
        allRecipes.value = response.data;
    })
    .catch((err) => console.error(err));

const addedRecipe = ref(null);
const insertRecipe = () => {
    if (addedRecipe.value) {
        embedRecipes.value = [...embedRecipes.value, addedRecipe.value];
        addedRecipe.value = null;
    }
};
const removeEmbedRecipe = (index: number) => {
    embedRecipes.value = embedRecipes.value.filter((_, i) => i !== index);
};

const recipeBuf = computed(() => recipes.value);
const embedRecipes = computed({
    get: () => recipeBuf.value,
    set: (v) => {
        props.updateAttributes({
            recipes: v.map((recipe: Recipe, index: number) => {
                return {
                    id: recipe.id,
                    order: index,
                };
            }),
        });

        // Happy thoughts
        recipes.value = v;
    },
});
</script>
<template>
    <node-view-wrapper>
        <div v-if="node.attrs.type === 'recipe-list'" class="not-prose">
            <draggable v-if="embedRecipes.length" v-model="embedRecipes" class="mt-1.5" ghost-class="bg-gray-100"
                item-key="order" tag="ul">
                <template #item="{ element, index }">
                    <div
                        class="flex justify-between items-center py-2.5 px-4 border border-t-0 border-gray-200 select-none first:rounded-t-lg first:border-t last:border-b-0">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <DraggableIcon class="w-6 h-6 text-gray-500 cursor-move" />
                            </div>
                            <div>
                                <h4 class="text-lg font-medium">
                                    {{ element.title }}
                                </h4>
                                <p class="max-w-sm text-gray-700 truncate">
                                    {{ element.description }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="p-2 -m-2 text-gray-500 rounded-xl hover:text-gray-700 hover:bg-gray-50"
                                @click="removeEmbedRecipe(index)">
                                <XMarkIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </template>
            </draggable>
            <div v-else>
                <div class="py-2.5 px-4 rounded-t-lg border-t select-none border-x">
                    <p class="text-gray-700">Aucune recette ajoutée.</p>
                </div>
            </div>
            <form @submit.prevent="insertRecipe"
                class="flex justify-between items-end py-4 px-6 bg-gray-50 rounded-b-md border">
                <ModelSearch v-model="addedRecipe" :first="true" :models="allRecipes" class="w-full"
                    label="Ajouter une recette" placeholder="Tarte aux pommes" search-property="title" />

                <SecondaryButton type="submit" class="ml-4">
                    Ajouter
                </SecondaryButton>
            </form>
        </div>
        <div v-else class="py-1 px-4 border">
            Erreur: type d'intégration non supporté: {{ node.attrs.type }}
        </div>
    </node-view-wrapper>
</template>
