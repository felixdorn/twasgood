<script lang="ts" setup>
import Connected from "@/Layouts/Connected.vue";
import Input from "@/Components/Input.vue";
import {Bars3BottomLeftIcon, DocumentIcon, LinkIcon, PlusCircleIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import Button from "@/Components/Button.vue";
import ModelSearch from "@/Components/ModelSearch.vue";
import {Article, Recipe, Section} from "@/types";
import {Link, router, useForm} from "@inertiajs/vue3";
import {PencilIcon} from "@heroicons/vue/24/solid";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {computed, ref} from "vue";
import draggable from "vuedraggable";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps<{
    section: Section & { recipes: Recipe[], activation_periods: any[], article: Article },
    recipes: Recipe[],
    articles: Article[]
    activation_period_types: any[]
}>()

const form = useForm({
    title: props.section.title,
    description: props.section.description,
    force_hide: props.section.force_hide,
})

const recipe = ref(null)
const selectedRecipe = computed({
    get() {
        return recipe.value
    },
    set(value) {
        addRecipeForm.recipe = value.id
        recipe.value = value
    }
})
const addRecipeForm = useForm({
    recipe: null
})
const sectionRecipes = computed({
    get: () => props.section.recipes,
    set: async (values: any) => {
        const form = useForm({
            recipes: values.map((value: any) => value.id)
        })

        await form.post(route('console.sections.order', {section: props.section.id}, {
            preserveScroll: true
        }))
    }
})

const detachRecipe = (recipe: Recipe) => router.post(route('console.sections.detach', {
    section: props.section.id,
    recipe: recipe.id
}), {
    preserveScroll: true
})

/*

const add_custom_range = ref(false)
const add_custom_day = ref(false)
const add_some_seasons = ref(false)

const removeCustomPeriodForm = () => {
    add_custom_range.value = false
    add_custom_day.value = false
    add_some_seasons.value = false
}
const addActivationPeriod = (type) => {
    if (type.id === 'CustomRange' || type.id === 'CustomDay' || type.id === 'SomeSeasons') {
        add_custom_range.value = type.id === 'CustomRange'
        add_custom_day.value = type.id === 'CustomDay'
        add_some_seasons.value = type.id === 'SomeSeasons'
        return;
    }

    router.post(
        route('console.sections.add-activation-period', {section: props.section.id, activationPeriodType: type.name}),
        {preserveScroll: true}
    )
}
const removeActivationPeriod = (type) => router.delete(
    route('console.sections.remove-activation-period', {activationPeriod: type.id}),
    {preserveScroll: true}
)

const addCustomPeriodForm = useForm({
    custom_date: null
})
const addCustomPeriod = () => {
    if (add_custom_day) {
        router.post(
            route('console.sections.add-custom-date', {section: props.section.id}),
            {
                custom_date: addCustomPeriodForm.custom_date,
            },
            {preserveScroll: true}
        )
    }

    removeCustomPeriodForm()
}
*/
const addRecipe = (e) => addRecipeForm.post(route('console.sections.attach', {section: props.section.id}), {
    onSuccess: () => {
        e.target.reset()
    }
})
const associateArticle = (e) => router.post(route('console.sections.associate-article', {
    section: props.section.id,
    article: associatedArticle.value.id
}), {
    preserveScroll: true,

    onSuccess: () => {
        associatedArticle.value = null
        e.target.reset()
    }
})
const associatedArticle = ref(null)

const removeAssociatedArticle = () => router.delete(route('console.sections.dissociate-article', {
    section: props.section.id,
}), {
    preserveScroll: true
})
</script>
<template>
    <Connected :title='`Éditer la partie "${section.title}"`'>

        <div class="max-w-lg mx">
            <form @submit.prevent="form.post(route('console.sections.update', { section: section.id }))">
                <Input
                    v-model="form.title"
                    :icon="DocumentIcon"
                    autofocus
                    label="Titre"
                    name="title"
                    placeholder="5 recettes pleines de fraîcheur"
                    required
                    type="text"
                />

                <Input
                    v-model="form.description"
                    :icon="Bars3BottomLeftIcon"
                    :required="false"
                    label="Description"
                    name="description"
                    placeholder="De la fraïcheur dans l'assiette tout l'été"
                    type="text"
                />

                <Checkbox v-model="form.force_hide" :checked="form.force_hide" label="Ne pas afficher la partie"
                          name="force_hide"/>

                <Button :icon="PencilIcon" class="mt-6">
                    Mettre à jour
                </Button>
            </form>

            <hr class="mt-8 mb-4">

            <form class="flex items-end" @submit.prevent="addRecipe">
                <ModelSearch v-model="selectedRecipe" :models="recipes" class="w-full"
                             label="Recettes"
                             placeholder="Chocolat chaud"
                             required
                             search-property="title"
                />
                <SecondaryButton :icon="PlusCircleIcon" class="whitespace-nowrap ml-4" type="submit">
                    Ajouter la recette
                </SecondaryButton>
            </form>

            <div v-if="!section.recipes.length" class="mt-4 bg-white border text-gray-700 py-4 px-6 rounded-xl">
                Aucune recette dans la partie.
            </div>
            <div v-else class="bg-white border rounded-xl mt-4">
                <draggable
                    v-model="sectionRecipes"
                    class="divide-y"
                    ghost-class="bg-gray-100"
                    item-key="order"
                    tag="ul"
                >
                    <template #item="{ element }">
                        <li class="px-6 py-4 flex items-center justify-between cursor-move hover:bg-gray-50">
                            <div>
                            <span class="font-semibold">
                                {{ element.title }}
                            </span>

                                <p class="truncate max-w-xs">
                                    {{ element.description }}
                                </p>
                            </div>

                            <form @submit.prevent="detachRecipe(element)">
                                <button class="mt-1">
                                    <XMarkIcon class="w-5 h-5 text-gray-400 hover:text-gray-500"/>
                                </button>
                            </form>
                        </li>
                    </template>
                </draggable>
            </div>

            <hr class="my-8">

            <div class="mt-4 text-gray-700">
                <div>
                    <h3 class="font-medium text-lg">
                        {{ section.article_id ? `Changer l'article associé` : 'Associer un article' }} à la section
                    </h3>

                    <div v-if="section.article_id" class="mt-2">
                        <h4 class="font-medium">Article actuellement associé</h4>
                        <Link :href="route('console.articles.edit', { article: section.article_id})" class="bg-white border rounded-xl mt-2 w-full flex items-center justify-between group">
                            <div class="pl-6 py-2.5">
                                <span class="font-bold text-lg group-hover:underline">
                                    {{ section.article.title }}
                                </span>

                                <p class="truncate">
                                    {{ section.article.description }}
                                </p>
                            </div>

                            <div class="pr-6 flex items-center">
                                <button class="isolate p-2 -m-2 text-gray-400  hover:bg-gray-50 rounded-xl"
                                        @click.prevent="removeAssociatedArticle">
                                    <XMarkIcon class="w-5 h-5"/>
                                </button>
                            </div>
                        </Link>
                    </div>

                    <form v-if="articles.length" @submit.prevent="associateArticle">
                        <ModelSearch v-model="associatedArticle"
                                     :label="section.article_id ? `Changer d'article` : 'Article'"
                                     :models="articles"
                                     placeholder="5 recettes pleines de fraîcheur" required search-property="title"/>

                        <Button :icon="LinkIcon" class="mt-4" type="submit">
                            Associer l'article
                        </Button>
                    </form>
                    <div v-else class="bg-white rounded-xl px-6 py-4 mt-2">
                        <p class="mt-1 text-gray-500">
                            Il semblerait qu'il n'y ait pas encore d'articles publiés.<br>

                            <span class="mt-2 flex space-x-4">
                                <Link :href="route('console.articles.create')"
                                      class="underline text-brand-700">Créer un article</Link>

                                <Link :href="route('console.articles.index', { state: 'unpublished'})"
                                      class="underline text-gray-700">
                                    Voir les articles non publiés
                                </Link>
                            </span>
                        </p>
                    </div>
                </div>

            </div>

            <!--
            <div class="mt-12 font-medium text-gray-700 flex items-center justify-between">
                <h2>Période d'activation</h2>

                <Menu as="div" class="relative inline-block text-left">
                    <div>
                        <MenuButton
                            class="inline-flex w-full justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                            Ajouter une période
                            <ChevronDownIcon aria-hidden="true" class="-mr-1 ml-2 h-5 w-5"/>
                        </MenuButton>
                    </div>

                    <transition leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            class="absolute right-0 z-10 mt-2 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="divide-y">
                                <MenuItem v-for="type in activation_period_types" v-slot="{ active }">
                                    <button
                                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'first:rounded-t-xl last:rounded-b-xl block w-full px-4 py-2 text-sm text-left whitespace-nowrap']"
                                        @click="addActivationPeriod(type)">
                                        {{ type.title }}
                                    </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>

            <form @submit.prevent="addCustomPeriod" class="mt-4 bg-white border rounded-xl px-6 py-6" v-if="add_custom_day || add_custom_range || add_some_seasons">
                <div v-if="add_custom_day">
                    <label for="custom_date" class="text-gray-800">Ajouter une date d'activation</label>
                    <input type="date" v-model="addCustomPeriodForm.custom_date" name="custom_date" id="custom_date" checked class="mt-2 border-gray-300 rounded-xl w-full focus:ring-1 focus:ring-brand-500 focus:border-brand-500 focus:outline-none" />
                </div>

                <div class="flex mt-6">
                    <Button :icon="PlusCircleIcon" >
                        Ajouter la période
                    </Button>
                    <SecondaryButton :icon="XMarkIcon" class="ml-4" @click="removeCustomPeriodForm">
                        Annuler
                    </SecondaryButton>
                </div>
            </form>

            <div v-if="section.activation_periods.length === 0">
                <div class="mt-4 bg-white border text-gray-700 py-4 px-6 rounded-xl">
                    Aucune période d'activation.
                </div>
            </div>
            <div v-else class="mt-8 space-y-2">
                <div v-for="type in section.activation_periods"
                     class="bg-white border px-6 py-2 rounded-xl flex items-center justify-between">
                    <span>{{ type.title }}</span>
                    <form @submit.prevent="removeActivationPeriod(type)">
                        <button class="mt-1">
                            <XMarkIcon class="w-5 h-5 text-gray-400 hover:text-gray-500"/>
                        </button>
                    </form>
                </div>
            </div>
    -->
        </div>
    </Connected>
</template>
