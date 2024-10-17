<script lang="ts" setup>
import type {Ingredient, Recipe} from "@/Console/types";
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from '@headlessui/vue'
import {AdjustmentsHorizontalIcon, CheckCircleIcon, PlusIcon, ScaleIcon} from "@heroicons/vue/24/outline";
import Button from "@/Console/Components/Button.vue";
import {computed, ref} from "vue";
import ModelSearch from "@/Console/Components/ModelSearch.vue";
import {useForm} from "@inertiajs/vue3";
import Input from "@/Console/Components/Input.vue";
import Checkbox from "@/Console/Components/Checkbox.vue";
import Modal from "@/Console/Components/Modal.vue";

const props = defineProps<{
    recipe: Recipe,
    ingredients: Ingredient[],
    recipes: Recipe[],
}>()


const types = ["Ingrédient", "Recette"]
const activeType = ref<string>(types[0])

const form = useForm({
    id: null,
    details: '',
    quantity: '',
    optional: false,
})

const prerequisite = ref(null)
const selectedPrerequisite = computed({
    get: () => prerequisite.value,
    set: (v) => {
        prerequisite.value = v
        form.id = (v as any).id
    }
})
const handleTypeChange = computed({
    get: () => activeType.value,
    set: (v) => {
        activeType.value = v
        prerequisite.value = null
        form.reset('id', 'quantity', 'details')
    }
})

const submit = () => form.post(route('console.recipes.prerequisite.store', {
    recipe: props.recipe.id,
    prerequisiteType: activeType.value === 'Recette' ? 'recipe' : 'ingredient',
    prerequisite: prerequisite.value
}), {
    onSuccess: () => {
        form.reset('id', 'quantity', 'details')
        activeType.value = 'Ingrédient'
        prerequisite.value = null
    },
    preserveScroll: true
})

</script>
<template>
    <Modal>
        <template #title>
            Ajouter un prérequis
        </template>

        <form @submit.prevent="submit">
            <RadioGroup v-model="handleTypeChange" class="mt-4">
                <RadioGroupLabel class="block font-medium text-gray-700">Type du prérequis</RadioGroupLabel>

                <div class="mt-1 grid grid-cols-2 sm:gap-x-4">
                    <RadioGroupOption v-for="type in types" :key="type" v-slot="{ checked, active }" :value="type"
                                      as="template">
                        <div
                            :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'border-brand-500 ring-2 ring-brand-500' : '', 'relative bg-white border rounded-xl shadow-sm p-4 flex cursor-pointer focus:outline-none']">
                            <div class="flex-1 flex">
                                <div class="flex flex-col">
                                    <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                                        {{ type }}
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

            <div v-if="activeType === 'Ingrédient'">
                <ModelSearch v-model="selectedPrerequisite" :models="ingredients" label="Ingrédient"
                             search-property="name"/>
                <p class="text-sm text-gray-700 mt-2">
                    Vous ne trouvez pas votre ingrédient ?
                    <a :href="route('console.ingredients.create')" class="underline" target="_blank"> Ajoutez-le</a>.
                </p>
            </div>
            <div v-else>
                <ModelSearch v-if="activeType === 'Recette'" v-model="selectedPrerequisite" :models="recipes"
                             label="Recette"
                             search-property="title"/>
                <p class="text-sm text-gray-700 mt-2">
                    Vous ne trouvez pas la recette ?
                    <a :href="route('console.recipes.create')" class="underline" target="_blank"> Ajoutez-la</a>.
                </p>
            </div>

            <div v-if="form.id !== null">
                <Input v-model="form.details" :icon="AdjustmentsHorizontalIcon" :required="false" label="Détails"
                       placeholder="(émincé)"/>

                <Input v-model="form.quantity" :icon="ScaleIcon" label="Quantité" placeholder="1 kilo"/>

                <div class="mt-6 mb-7">
                    <Checkbox v-model="form.optional" :checked="form.optional === 1" label="L'ingrédient est optionnel"
                              name="optional"/>
                </div>

                <p class="text-brand-500 font-semibold border-t mt-6 pt-4">Aperçu</p>
                <div class="border mt-1 py-2 px-4 rounded-xl">
                    <span class="font-semibold">
                        {{ prerequisite[activeType === 'Ingrédient' ? 'name' : 'title'] }}
                        <span v-if="form.details" class="font-normal text-gray-700">{{ form.details }}</span>
                    </span>
                    <p v-if="form.quantity" class="mt-1 text-gray-700">
                        {{ form.quantity }}
                    </p>
                </div>
            </div>

            <Button :icon="PlusIcon" class="mt-4" type="submit" :disabled="form.processing">
                Ajouter
            </Button>
        </form>
    </Modal>
</template>
