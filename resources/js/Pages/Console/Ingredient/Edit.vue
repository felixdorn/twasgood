<script lang="ts" setup>
import Input from "@/Components/Input.vue";
import {ArrowsRightLeftIcon, CheckCircleIcon, DocumentIcon, TrashIcon} from "@heroicons/vue/24/outline";
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from '@headlessui/vue'
import {router, useForm} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";
import Connected from "@/Layouts/Connected.vue";
import type {Ingredient, Prerequisite, Recipe} from "@/types";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ModelSearch from "@/Components/ModelSearch.vue";
import {computed, ref} from "vue";

const props = defineProps<{
    ingredient: Ingredient & { prerequisites: (Prerequisite & { recipe: Recipe })[] },
    recipes: Recipe[],
    usage_count: number,
}>()

const form = useForm({
    name: props.ingredient.name,
    type: props.ingredient.type,
    contains_gluten: props.ingredient.contains_gluten,
    contains_dairy: props.ingredient.contains_dairy,
})

const transferRecipe = ref()
const selectedTransferRecipe = computed({
    get() {
        return transferRecipe.value
    },
    set(value) {
        transferForm.recipe_id = value.id
        transferRecipe.value = value
    }
})

const transferForm = useForm({
    recipe_id: null,
})

const types = [{id: "vegan", name: "Vegan"}, {id: "vegetarian", name: "Végétarien"}, {id: "meat", name: "Carné"},]
</script>
<template>
    <Connected title="Mettre à jour un ingrédient" width="max-w-2xl">
        <form @submit.prevent="form.put(route('console.ingredients.update', { ingredient: ingredient.id }))">
            <RadioGroup v-model="form.type" class="mt-4">
                <RadioGroupLabel class="block font-medium text-gray-700">Type</RadioGroupLabel>

                <div class="mt-1 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                    <RadioGroupOption v-for="type in types" :key="type.id" v-slot="{ checked, active }" :value="type.id"
                                      as="template">
                        <div
                            :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'border-brand-500 ring-2 ring-brand-500' : '', 'relative bg-white border rounded-xl shadow-sm p-4 flex cursor-pointer focus:outline-none']">
                            <div class="flex-1 flex">
                                <div class="flex flex-col">
                                    <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                                        {{ type.name }}
                                    </RadioGroupLabel>
                                </div>
                            </div>
                            <CheckCircleIcon :class="[!checked ? 'invisible' : '', 'h-5 w-5 text-brand-600']"
                                             aria-hidden="true"/>
                            <div
                                :class="[active ? 'border' : 'border-2', checked ? 'border-brand-500' : 'border-transparent', 'absolute -inset-px rounded-xl pointer-events-none']"
                                aria-hidden="true"/>
                        </div>
                    </RadioGroupOption>
                </div>
            </RadioGroup>
            <Input v-model="form.name" :icon="DocumentIcon" label="Nom" name="name" placeholder="Cacao" type="text"/>
            <fieldset class="space-y-5">
                <legend class="sr-only">Allergènes</legend>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="gluten" v-model="form.contains_gluten" aria-describedby="gluten-description"
                               class="focus:ring-brand-500 h-4 w-4 text-brand-600 border-gray-300 rounded"
                               name="comments" type="checkbox"/>
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="font-medium text-gray-700" for="gluten">Contient du gluten</label>
                        <p id="gluten-description" class="text-gray-500">
                            Le gluten est un mélange de protéines contenues dans le blé, le seigle, l'orge et l'avoine.
                        </p>
                    </div>
                </div>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="dairy" v-model="form.contains_dairy" aria-describedby="dairy-description"
                               class="focus:ring-brand-500 h-4 w-4 text-brand-600 border-gray-300 rounded"
                               name="candidates" type="checkbox"/>
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="font-medium text-gray-700" for="dairy">Contient du lactose</label>
                        <p id="dairy-description" class="text-gray-500">
                            Le lactose est un sucre naturellement présent dans le lait et les produits laitiers.
                        </p>
                    </div>
                </div>
            </fieldset>


            <div class="flex mt-6 space-x-4">
                <Button :icon="PlusIcon" type="submit">
                    Mettre à jour
                </Button>

                <SecondaryButton
                    :icon="TrashIcon"
                    class="float-right" type="button" @click="router.delete(route('console.ingredients.destroy', { type: 'ingredient', id: ingredient.id }))">
                    Supprimer
                </SecondaryButton>
            </div>
        </form>

        <form v-if="usage_count > 0"
              @submit.prevent="transferForm.post(route('console.ingredients.transfer', ingredient.id))">
            <h2 class="text-xl font-bold mt-12 text-gray-700">
                Supprimer et remplacer par une recette existante
            </h2>

            <p class="mt-1 text-gray-700">
                Cette action va changer l'ingrédient dans toutes les recettes qui l'utilisent et le remplacer
                par la recette séléctionnée, la quantité et les détails de l'ingrédient seront préservés.
            </p>

            <ModelSearch v-model="selectedTransferRecipe" :models="recipes" label="Recette" placeholder="Chocolat chaud"
                         search-property="title"/>

            <SecondaryButton :icon="ArrowsRightLeftIcon" class="mt-6">
                Mettre à jour {{ usage_count }} recette{{ usage_count > 1 ? 's' : '' }}
            </SecondaryButton>

            <h3 class="mt-4 font-semibold">Recettes concernées</h3>
            <ul class="list-disc list-inside">
                <li v-for="p in ingredient.prerequisites">{{ p.recipe.title }}</li>
            </ul>
        </form>
    </Connected>
</template>
