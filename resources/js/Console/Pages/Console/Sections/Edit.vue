<script lang="ts" setup>
import Connected from "@/Console/Layouts/Connected.vue";
import Input from "@/Console/Components/Input.vue";
import {Bars3BottomLeftIcon, DocumentIcon, LinkIcon, PlusCircleIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import Button from "@/Console/Components/Button.vue";
import ModelSearch from "@/Console/Components/ModelSearch.vue";
import {Article, Recipe, Section} from "@/Console/types";
import {Link, router, useForm} from "@inertiajs/vue3";
import {PencilIcon} from "@heroicons/vue/24/solid";
import SecondaryButton from "@/Console/Components/SecondaryButton.vue";
import {computed, ref} from "vue";
import draggable from "vuedraggable";
import Checkbox from "@/Console/Components/Checkbox.vue";

const props = defineProps<{
    section: Section & { recipes: Recipe[], article: Article },
    recipes: Recipe[],
    articles: Article[]
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
        </div>
    </Connected>
</template>
