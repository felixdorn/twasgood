<script lang="ts" setup>
import Input from "@/Console/Components/Input.vue";
import {CheckCircleIcon, DocumentIcon} from "@heroicons/vue/24/outline";
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from '@headlessui/vue'
import {useForm} from "@inertiajs/vue3";
import Button from "@/Console/Components/Button.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";
import Connected from "@/Console/Layouts/Connected.vue";

const form = useForm({
    name: "",
    type: "vegan",
    contains_gluten: false,
    contains_dairy: false,
})

const types = [{id: "vegan", name: "Vegan"}, {id: "vegetarian", name: "Végétarien"}, {id: "meat", name: "Carné"}, {id: "    other", name: "Autre"}]
</script>
<template>
    <Connected title="Créer un ingrédient" width="max-w-2xl">
        <form @submit.prevent="form.post(route('console.ingredients.store'))">
            <RadioGroup v-model="form.type" class="mt-4">
                <RadioGroupLabel class="block font-medium text-gray-700">Type</RadioGroupLabel>

                <div class="mt-1 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                    <RadioGroupOption v-for="type in types" :key="type.id" v-slot="{ checked, active }" :value="type.id" as="template">
                        <div :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'border-brand-500 ring-2 ring-brand-500' : '', 'relative bg-white border rounded-xl shadow-sm p-4 flex cursor-pointer focus:outline-none']">
                            <div class="flex-1 flex">
                                <div class="flex flex-col">
                                    <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                                        {{ type.name }}
                                    </RadioGroupLabel>
                                </div>
                            </div>
                            <CheckCircleIcon :class="[!checked ? 'invisible' : '', 'h-5 w-5 text-brand-600']" aria-hidden="true" />
                            <div :class="[active ? 'border' : 'border-2', checked ? 'border-brand-500' : 'border-transparent', 'absolute -inset-px rounded-xl pointer-events-none']" aria-hidden="true" />
                        </div>
                    </RadioGroupOption>
                </div>
            </RadioGroup>
            <Input v-model="form.name" :icon="DocumentIcon" label="Nom" name="name" placeholder="Cacao" type="text" />
            <fieldset class="space-y-5">
                <legend class="sr-only">Allergènes</legend>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="gluten" v-model="form.contains_gluten" aria-describedby="gluten-description" class="focus:ring-brand-500 h-4 w-4 text-brand-600 border-gray-300 rounded" name="comments" type="checkbox" />
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
                        <input id="dairy" v-model="form.contains_dairy" aria-describedby="dairy-description" class="focus:ring-brand-500 h-4 w-4 text-brand-600 border-gray-300 rounded" name="candidates" type="checkbox" />
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="font-medium text-gray-700" for="dairy">Contient du lactose</label>
                        <p id="dairy-description" class="text-gray-500">
                            Le lactose est un sucre naturellement présent dans le lait et les produits laitiers.
                        </p>
                    </div>
                </div>
            </fieldset>

            <Button :icon="PlusIcon" class="mt-6 rounded-b-xl" type="submit">
                Ajouter
            </Button>
        </form>
    </Connected>
</template>
