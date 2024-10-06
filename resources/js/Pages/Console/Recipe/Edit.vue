<script lang="ts" setup>
import type {Asset, Category, Ingredient, Prerequisite, Recipe, Slug, Tag} from "@/types";
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import {
    ArrowLeftIcon,
    ArrowPathIcon,
    CheckCircleIcon,
    ClockIcon,
    Cog8ToothIcon,
    PaperAirplaneIcon,
    PhotoIcon,
    PlusIcon,
    ScaleIcon,
    TagIcon,
    XMarkIcon
} from "@heroicons/vue/24/outline";
import {LockClosedIcon, LockOpenIcon, PencilIcon, TrashIcon,} from "@heroicons/vue/24/solid";
import axios from "axios";
import Input from "@/Components/Input.vue";
import {computed, ref} from "vue";
import Button from "@/Components/Button.vue";
import InlineModal from "@/Components/InlineModal.vue";
import ModelSearch from "@/Components/ModelSearch.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import RichText from "@/Components/RichText.vue";
import {debounce, throttle} from "@/Components/editor/util";
import Textarea from "@/Components/Textarea.vue";
import Checkbox from "@/Components/Checkbox.vue";
import draggable from "vuedraggable"
import Extra from "@/Layouts/Extra.vue";
import {useSync, StatusIndicator} from "@/sync";

const props = defineProps<{
    recipe: Recipe & {
        prerequisites: Prerequisite[],
        banner: Asset,
        illustrations: Asset[],
        slugs: Slug[]
    },
    recipes: Recipe[],
    ingredients: Ingredient[],
    categories: Category[],
    typeTags: Tag[]
    seasonTags: Tag[]
}>()

const sync = useSync('recipe', props.recipe.id)
const status = ref<StatusIndicator>(StatusIndicator.Updated)
sync.onStatusUpdate((newStatus: StatusIndicator) => status.value = newStatus)


const errors = ref<Record<string, string>>({})

const update = async (property: keyof Recipe, event: InputEvent | any) => {
    sync.updateStatus(StatusIndicator.Updating)

    try {
        const res = await axios.patch(route('console.recipes.update', {recipe: props.recipe}), {
            [property]: event instanceof InputEvent ? (event.target as HTMLInputElement).value : event
        });

        props.recipe.publishable = res?.data?.publishable ?? false

        delete errors.value[property]

        sync.updateStatus(Object.keys(errors.value).length === 0 ? StatusIndicator.Updated : StatusIndicator.Error)
    } catch (e) {
        console.error(e)

        if (e?.response?.status === 422) {
            errors.value[property] = e.response.data.errors[property][0]
        }

        sync.updateStatus(StatusIndicator.Error)
    }
}

const showSettingsModal = ref(false)

const prerequisites = computed({
    get: () => prerequisitesBuf.value,
    set: async (values: any) => {
        const form = useForm({
            prerequisites: values.map((v) => v.id)
        })

        // Happy thoughts
        prerequisitesBuf.value = values

        form.put(route('console.recipes.prerequisite.order', {recipe: props.recipe.id}), {
            preserveScroll: true,
        })
    }
})
const prerequisitesBuf = computed<Prerequisite[]>(() => props.recipe.prerequisites)

const illustrations = computed({
    get: () => props.recipe.illustrations,
    set: (values) => sync.orderAssets(values, {
        onSuccess: (assets: Asset[]) => props.recipe.illustrations = assets
    })
})

const toggleTag = async (event) => {
    const el = event.target.nodeName === 'LI' ? event.target : event.target.parentNode
    const checkbox = el.firstChild

    checkbox.checked = !checkbox.checked

    sync.updateStatus(StatusIndicator.Updating)

    try {
        await axios.post(route('console.recipes.tags.toggle', {
            recipe: props.recipe.id,
            tag: checkbox.value
        }))
    } catch (e) {
        sync.updateStatus(StatusIndicator.Error)

        return
    }

    sync.updateStatus(StatusIndicator.Updated)
}
</script>
<template>
    <Head :title="recipe.title"/>
    <header
        :class="status === StatusIndicator.Error ? 'bg-red-100 text-red-700 border-red-100' : 'text-gray-500 border-gray-300'"
        class="fixed top-0 left-0 w-full bg-white border-b z-30"
    >
        <div class="flex items-center justify-between w-full px-6 py-4">
            <Link :href="route('console.recipes.index', { state: recipe.published_at ? 'published' : 'unpublished'})">
                <ArrowLeftIcon class="w-6 h-6"/>
            </Link>
            <h4 class="font-bold w-full ml-4 md:ml-0 md:w-auto font-display">{{ recipe.title }}</h4>
            <ul class="flex items-center space-x-4">
                <li>
                    <ArrowPathIcon
                        v-if="status === StatusIndicator.Updating"
                        class="w-6 h-6 text-yellow-500 animate-spin"
                    />
                    <CheckCircleIcon v-else-if="status === StatusIndicator.Updated" class="w-6 h-6 text-green-500"/>
                    <XMarkIcon
                        v-else
                        class="w-6 h-6 text-red-500"
                    />
                </li>
                <li class="flex items-center">
                    <button @click="showSettingsModal = true">
                        <Cog8ToothIcon class="w-6 h-6"/>
                    </button>
                </li>
                <li>
                    <button
                        :class="[recipe.publishable ? '' : 'opacity-30 cursor-not-allowed']"
                        :disabled="!recipe.publishable"
                        class="top-1 relative"
                        @click="router.post(route('console.recipes.publish', { recipe: recipe.id }))">
                        <PaperAirplaneIcon class="w-6 h-6"/>
                    </button>
                </li>
            </ul>
        </div>

        <div v-if="Object.values(errors).length" class="py-4 px-7 bg-red-500 text-white font-bold">
            Ce document n'est pas valide: la version à l'écran ne correspond pas à celle sauvegardée.
        </div>

        <div class="divide-y">
            <div v-for="(error, n) in Object.values(errors)" class="py-2 px-7 bg-white text-red-500 font-semibold">
                Erreur #{{ n + 1 }}: {{ error }}
            </div>
        </div>
    </header>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 mb-8">
        <ImageUploader
            :error="errors['banner']"
            :value="recipe.banner?.path"
            class="border-b-0 border bg-gray-50 h-[36rem]"
            @input="sync.syncAsset($event, {
                group: 'banner:unique',
                asset: recipe.banner,
                onSuccess: (asset: Asset) => props.recipe.banner = asset
            })"
        />
        <Input
            :icon="PhotoIcon"
            :value.="recipe.banner?.alt"
            class="rounded-t-none -mt-0.5"
            first
            hide-label
            label="Légende de la bannière"
            placeholder="Légende de la bannière"
            required
            type="text"
            @change="sync.syncAsset($event, {
                group: 'banner:unique',
                asset: props.recipe.banner
            })"
        />

        <input
            v-model="recipe.title"
            class="focus:outline-none border-none focus:border-none  focus:ring-0 w-full bg-transparent text-center shadow-none text-5xl font-bold mt-4 md:mt-5"
            placeholder="Titre"
            required
            type="text"
            @input="debounce(() => update('title', $event), 200)"
        />

        <div class="flex flex-col-reverse md:grid md:grid-cols-3 md:gap-x-4 mt-4">
            <div class="space-y-8">
                <section class="border rounded-xl bg-">
                    <header class="px-4 py-4 border-b bg-gray-50 rounded-t-xl">
                        <h5 class="font-semibold">Tags</h5>
                    </header>
                    <div class="bg-white p-4 rounded-b-xl">
                        <ul class="flex flex-wrap gap-x-4 gap-y-3">
                            <li v-for="tag in typeTags"
                                class="cursor-pointer bg-gray-100 inline-flex px-2 py-1 rounded-xl text-sm font-medium text-gray-800 items-center justify-between"
                                @click="toggleTag">
                                <input
                                    :checked="recipe.tags.find(t => t.id === tag.id)"
                                    :value="tag.id"
                                    class="h-4 w-4 pointer-events-none rounded-xl border-gray-300 text-brand-600 focus:ring-brand-500"
                                    type="checkbox"/>
                                <span class="ml-2 select-none">{{ tag.name }}</span>
                            </li>
                        </ul>
                    </div>
                </section>
                <section class="border rounded-xl bg-white">
                    <header class="px-4 py-4 border-b bg-gray-50 rounded-t-xl">
                        <h5 class="font-semibold">Prérequis</h5>
                    </header>
                    <draggable
                        v-model="prerequisites"
                        ghost-class="bg-gray-100"
                        item-key="order"
                        tag="ul"
                    >
                        <template #item="{ element }">
                            <li class="px-4 py-2 flex justify-between cursor-move hover:bg-gray-50">
                                <div class="w-full">
                                    <div class="flex justify-between items-center">
                                        <component :is="element.type === 'recipe'? Link : 'p'"
                                                   :class="{'underline': element.type === 'recipe'}"
                                                   :href="element.type === 'recipe' ? route('console.recipes.edit', element.id) : undefined"
                                                   class="font-semibold">
                                            {{
                                                {
                                                    'recipe': element.prerequisite.title,
                                                    'ingredient': element.prerequisite.name
                                                }[element.type]
                                            }}
                                            <span v-if="element.details" class="font-normal text-gray-700">
                                        {{ ' ' + element.details }}
                                        </span>
                                        </component>

                                        <component :is="element.optional ? LockOpenIcon : LockClosedIcon"
                                                   class="w-4 h-4 inline-block mr-0.5 text-gray-500"/>
                                    </div>

                                    <p class="mt-0.5 text-gray-700">
                                        <ScaleIcon class="w-4 h-4 inline-block mr-0.5"/>
                                        {{ element.quantity }}
                                    </p>
                                    <div class="flex mb-2 mt-3 space-x-2">
                                        <Link
                                            :href="route('console.recipes.prerequisite.edit', { recipe: recipe.id, prerequisite: element.id})"
                                            class="p-2 rounded-xl hover:bg-gray-100 border focus:ring bg-white">
                                            <PencilIcon class="w-4 text-gray-500 h-4"/>
                                        </Link>
                                        <form
                                            @submit.prevent="router.delete(route('console.recipes.prerequisite.destroy', { recipe: recipe.id, prerequisite: element.id }),  { preserveScroll: true })">
                                            <button class="p-2 rounded-xl hover:bg-gray-100 border focus:ring bg-white">
                                                <TrashIcon class="w-4 text-gray-500 h-4"/>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </draggable>
                    <div v-if="recipe.prerequisites.length === 0" class="border-t py-4 px-4">
                        <span class="text-gray-700">Cette recette n'a pas de prérequis.</span>
                    </div>

                    <footer class="px-4 py-4 border-t">
                        <Link
                            :preserve-scroll="true"
                            :preserve-state="true"
                            :only="['modal']"
                            :class="'rounded-t-xl rounded-b-xl'"
                            :href="route('console.recipes.prerequisite.create', recipe.id)" :icon="PlusIcon"
                        >
                            <Button :icon="PlusIcon" class="w-full justify-center">
                                Ajouter un prérequis
                            </Button>
                        </Link>
                    </footer>
                </section>

                <div :class="illustrations.length === 0 ? '!mt-0': ''">
                    <draggable v-model="illustrations" class="space-y-4" ghost-class="opacity-50" item-key="order"
                               tag="ul">
                        <template #item="{ element, index }: { element: Asset, index: number }">
                            <li class="relative">
                                <ImageUploader
                                    :value="element.path"
                                    height="h-[12rem]"
                                    class="border bg-gray-50 w-full object-cover object-center"
                                    @change="sync.syncAsset($event, {
                                        asset: element,
                                        onSuccess: (asset: Asset) => illustrations[index] = asset
                                    })"
                                />
                                <Input
                                    :icon="PhotoIcon"
                                    :label="`Légende de l'image ${index + 1}`"
                                    :placeholder="`Légende de l'image ${index + 1}`"
                                    :value="element.alt"
                                    class="rounded-t-none -mt-0.5"
                                    first
                                    hide-label
                                    required
                                    type="text"
                                    @change="sync.syncAsset($event, {
                                        asset: element,
                                        onSuccess: (asset: Asset) => illustrations[index] = asset
                                    })"
                                />

                                <form
                                    @submit.prevent="sync.removeAsset(element, { onSuccess: () => illustrations.splice(index, 1) })">
                                    <button class="absolute top-4 right-4 rounded-xl bg-white p-2 text-gray-500">
                                        <TrashIcon class="w-4 h-4"/>
                                    </button>
                                </form>
                            </li>
                        </template>
                    </draggable>
                    <SecondaryButton :icon="PlusIcon" class="w-full justify-center mt-4" @click="sync.createAsset({
                        group: 'illustrations',
                        onSuccess: (asset: Asset) => illustrations.push(asset)
                    })">
                        Ajouter une image
                    </SecondaryButton>
                </div>

                <section class="rounded-xl">
                    <ul class="text-sm">
                        <li class="bg-white border inline-block rounded-xl text-gray-700">
                            <form @submit.prevent="router.delete(route('console.recipes.destroy', recipe.id))">
                                <button class="px-3 py-1.5" type="submit">
                                    <TrashIcon class="w-4 h-4 inline-block mr-1 -mt-0.5"/>
                                    Supprimer
                                </button>
                            </form>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="col-span-2">
                <header
                    class="bg-gray-50 border  rounded-xl rounded-b-none px-4 py-3 md:py-2 md:flex md:items-center md:justify-between">
                    <h5 class="font-semibold w-full">Préparation</h5>
                    <Input
                        v-model="recipe.time_to_prepare"
                        :icon="ClockIcon"
                        class="w-full mt-1 md:mt-0"
                        first
                        hide-label
                        placeholder="(vide)"
                        @input="debounce(() => update('time_to_prepare', $event), 200)"
                    />
                </header>
                <RichText :content="JSON.parse(recipe.content)"
                          :recipes="recipes"
                          buttonsClass="border-b border-x"
                          class="border-x border-b rounded-xl rounded-t-none"
                          @change="debounce(() => update('content', $event), 200)"/>
            </div>
        </div>
    </div>
    (

    <InlineModal :show="showSettingsModal" @close="showSettingsModal = false">
        <template #title>
            Paramètres
        </template>

        <div class="space-y-6">

            <ModelSearch v-model="recipe.category" :models="categories" label="Catégorie" searchProperty="name"
                         @change="update('category_id', $event.id)"/>

            <div>
                <h4 class="font-medium text-gray-700">Saison(s)</h4>
                <ul class="flex flex-wrap gap-x-4 gap-y-3 mt-2">
                    <li v-for="tag in seasonTags"
                        class="cursor-pointer bg-gray-100 inline-flex px-2 py-1 rounded-xl text-sm font-medium text-gray-800 items-center justify-between"
                        @click="toggleTag">
                        <input
                            :checked="recipe.tags.find(t => t.id === tag.id)"
                            :value="tag.id"
                            class="h-4 w-4 pointer-events-none rounded-xl border-gray-300 text-brand-600 focus:ring-brand-500"
                            type="checkbox"/>
                        <span class="ml-2 select-none">{{
                                {
                                    'all': 'Toutes saisons',
                                    'winter': 'Hiver',
                                    'spring': 'Printemps',
                                    'summer': 'Été',
                                    'autumn': 'Automne',
                                }[tag.name]
                            }}</span>
                    </li>
                </ul>
            </div>


            <Input
                v-model="recipe.short_title"
                :icon="TagIcon"
                label="Titre court"
                type="text"
                @input="update('short_title', $event)"
            />


            <Textarea
                v-model="recipe.description"
                label="Accroche"
                name="description"
                @input="debounce(() => update('description', $event), 200)"
            />

            <div>
                <Checkbox :checked="recipe.uses_sterilization"
                          label="Cet article a une étape de stérilisation"
                          name="uses_sterilization" @input="update('uses_sterilization', $event.target.checked)"/>
            </div>
        </div>

        <SecondaryButton :icon="XMarkIcon" class="mt-4" @click="showSettingsModal = false">
            Fermer
        </SecondaryButton>
    </InlineModal>
    <Extra/>
</template>
