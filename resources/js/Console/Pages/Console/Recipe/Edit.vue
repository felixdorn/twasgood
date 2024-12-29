<script lang="ts" setup>
import type {
    Asset,
    Category,
    Ingredient,
    Prerequisite,
    Recipe,
    Slug,
    Tag,
} from "@/Console/types";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
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
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import {
    LockClosedIcon,
    LockOpenIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/solid";
import axios from "axios";
import Input from "@/Console/Components/Input.vue";
import { computed, ref } from "vue";
import Button from "@/Console/Components/Button.vue";
import InlineModal from "@/Console/Components/InlineModal.vue";
import ModelSearch from "@/Console/Components/ModelSearch.vue";
import SecondaryButton from "@/Console/Components/SecondaryButton.vue";
import ImageUploader from "@/Console/Components/ImageUploader.vue";
import RichText from "@/Console/Components/RichText.vue";
import { debounce } from "@/Console/Components/editor/util";
import Textarea from "@/Console/Components/Textarea.vue";
import Checkbox from "@/Console/Components/Checkbox.vue";
import draggable from "vuedraggable";
import { useSync, StatusIndicator } from "@/Console/sync";

const props = defineProps<{
    recipe: Recipe & {
        prerequisites: Prerequisite[];
        banner: Asset;
        illustrations: Asset[];
        slugs: Slug[];
    };
    recipes: Recipe[];
    ingredients: Ingredient[];
    categories: Category[];
    typeTags: Tag[];
    seasonTags: Tag[];
}>();

const sync = useSync("recipe", props.recipe.id);
const status = ref<StatusIndicator>(StatusIndicator.Updated);
sync.onStatusUpdate((newStatus: StatusIndicator) => (status.value = newStatus));

const errors = ref<Record<string, string>>({});

const update = async (property: keyof Recipe, event: InputEvent | any) => {
    console.log(property);
    sync.updateStatus(StatusIndicator.Updating);

    try {
        const res = await axios.patch(
            route("console.recipes.update", { recipe: props.recipe }),
            {
                [property]:
                    event instanceof InputEvent
                        ? (event.target as HTMLInputElement).value
                        : event,
            },
        );

        props.recipe.publishable = res?.data?.publishable ?? false;

        delete errors.value[property];

        sync.updateStatus(
            Object.keys(errors.value).length === 0
                ? StatusIndicator.Updated
                : StatusIndicator.Error,
        );
    } catch (e) {
        console.error(e);

        if (e?.response?.status === 422) {
            errors.value[property] = e.response.data.errors[property][0];
        }

        sync.updateStatus(StatusIndicator.Error);
    }
};

const showSettingsModal = ref(false);

const prerequisites = computed({
    get: () => prerequisitesBuf.value,
    set: async (values: any) => {
        const form = useForm({
            prerequisites: values.map((v) => v.id),
        });

        // Happy thoughts
        prerequisitesBuf.value = values;

        form.put(
            route("console.recipes.prerequisite.order", {
                recipe: props.recipe.id,
            }),
            {
                preserveScroll: true,
            },
        );
    },
});
const prerequisitesBuf = computed<Prerequisite[]>(
    () => props.recipe.prerequisites,
);

const illustrations = computed({
    get: () => props.recipe.illustrations,
    set: (values) =>
        sync.orderAssets(values, {
            onSuccess: (assets: Asset[]) =>
                (props.recipe.illustrations = assets),
        }),
});

const toggleTag = async (event) => {
    const el =
        event.target.nodeName === "LI" ? event.target : event.target.parentNode;
    const checkbox = el.firstChild;

    checkbox.checked = !checkbox.checked;

    sync.updateStatus(StatusIndicator.Updating);

    try {
        await axios.post(
            route("console.recipes.tags.toggle", {
                recipe: props.recipe.id,
                tag: checkbox.value,
            }),
        );
    } catch (e) {
        sync.updateStatus(StatusIndicator.Error);

        return;
    }

    sync.updateStatus(StatusIndicator.Updated);
};
</script>
<template>

    <Head :title="recipe.title" />
    <header :class="status === StatusIndicator.Error
            ? 'bg-red-100 text-red-700 border-red-100'
            : 'text-gray-500 border-gray-300'
        " class="fixed top-0 left-0 z-30 w-full bg-white border-b">
        <div class="flex justify-between items-center py-4 px-6 w-full">
            <a :href="route('console.recipes.index', {
                state: recipe.published_at
                    ? 'published'
                    : 'unpublished',
            })
                ">
                <ArrowLeftIcon class="w-6 h-6" />
            </a>
            <h4 class="ml-4 w-full font-bold md:ml-0 md:w-auto font-display">
                {{ recipe.title }}
            </h4>
            <ul class="flex items-center space-x-4">
                <li>
                    <ArrowPathIcon v-if="status === StatusIndicator.Updating"
                        class="w-6 h-6 text-yellow-500 animate-spin" />
                    <CheckCircleIcon v-else-if="status === StatusIndicator.Updated" class="w-6 h-6 text-green-500" />
                    <XMarkIcon v-else class="w-6 h-6 text-red-500" />
                </li>
                <li class="flex items-center">
                    <button @click="showSettingsModal = true">
                        <Cog8ToothIcon class="w-6 h-6" />
                    </button>
                </li>
                <li>
                    <button :class="[
                        recipe.publishable
                            ? ''
                            : 'opacity-30 cursor-not-allowed',
                    ]" :disabled="!recipe.publishable" class="relative top-1" @click="
                            router.post(
                                route('console.recipes.publish', {
                                    recipe: recipe.id,
                                }),
                            )
                            ">
                        <PaperAirplaneIcon class="w-6 h-6" />
                    </button>
                </li>
            </ul>
        </div>

        <div v-if="Object.values(errors).length" class="py-4 px-7 font-bold text-white bg-red-500">
            Ce document n'est pas valide: la version à l'écran ne correspond pas
            à celle sauvegardée.
        </div>

        <div class="divide-y">
            <div v-for="(error, n) in Object.values(errors)" class="py-2 px-7 font-semibold text-red-500 bg-white">
                Erreur #{{ n + 1 }}: {{ error }}
            </div>
        </div>
    </header>
    <div class="px-4 mx-auto mt-20 mb-8 max-w-7xl sm:px-6 lg:px-8">
        <ImageUploader :error="errors['banner']" :value="recipe.banner?.url"
            class="bg-gray-50 border border-b-0 h-[36rem]" @input="
                sync.syncAsset($event, {
                    group: 'banner:unique',
                    asset: recipe.banner,
                    onSuccess: (asset: Asset) => (props.recipe.banner = asset),
                })
                " />
        <Input :icon="PhotoIcon" :value.="recipe.banner?.alt" class="-mt-0.5 rounded-t-none" first hide-label
            label="Légende de la bannière" placeholder="Légende de la bannière" required type="text" @change="
                sync.syncAsset($event, {
                    group: 'banner:unique',
                    asset: props.recipe.banner,
                })
                " />

        <input v-model="recipe.title"
            class="mt-4 w-full text-5xl font-bold text-center bg-transparent border-none shadow-none md:mt-5 focus:border-none focus:ring-0 focus:outline-none"
            placeholder="Titre" required type="text" @input="debounce(() => update('title', $event), 200)" />

        <div class="flex flex-col-reverse mt-4 md:grid md:grid-cols-3 md:gap-x-4">
            <div class="space-y-8">
                <section class="rounded-xl border bg-">
                    <header class="py-4 px-4 bg-gray-50 rounded-t-xl border-b">
                        <h5 class="font-semibold">Tags</h5>
                    </header>
                    <div class="p-4 bg-white rounded-b-xl">
                        <ul class="flex flex-wrap gap-y-3 gap-x-4">
                            <li v-for="tag in typeTags"
                                class="inline-flex justify-between items-center py-1 px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-xl cursor-pointer"
                                @click="toggleTag">
                                <input :checked="recipe.tags.find((t) => t.id === tag.id)
                                    " :value="tag.id"
                                    class="w-4 h-4 rounded-xl border-gray-300 pointer-events-none text-brand-600 focus:ring-brand-500"
                                    type="checkbox" />
                                <span class="ml-2 select-none">{{
                                    tag.name
                                    }}</span>
                            </li>
                        </ul>
                    </div>
                </section>
                <section class="bg-white rounded-xl border">
                    <header class="py-4 px-4 bg-gray-50 rounded-t-xl border-b">
                        <h5 class="font-semibold">Prérequis</h5>
                    </header>
                    <draggable v-model="prerequisites" ghost-class="bg-gray-100" item-key="order" tag="ul">
                        <template #item="{ element }">
                            <li class="flex justify-between py-2 px-4 cursor-move hover:bg-gray-50">
                                <div class="w-full">
                                    <div class="flex justify-between items-center">
                                        <component :is="element.type === 'recipe'
                                                ? Link
                                                : 'p'
                                            " :class="{
                                                underline:
                                                    element.type === 'recipe',
                                            }" :href="element.type === 'recipe'
                                                    ? route(
                                                        'console.recipes.edit',
                                                        element.id,
                                                    )
                                                    : undefined
                                                " class="font-semibold">
                                            {{
                                                {
                                                    recipe: element.prerequisite
                                                        .title,
                                                    ingredient:
                                                        element.prerequisite
                                                            .name,
                                                }[element.type]
                                            }}
                                            <span v-if="element.details" class="font-normal text-gray-700">
                                                {{ " " + element.details }}
                                            </span>
                                        </component>

                                        <component :is="element.optional
                                                ? LockOpenIcon
                                                : LockClosedIcon
                                            " class="inline-block mr-0.5 w-4 h-4 text-gray-500" />
                                    </div>

                                    <p class="mt-0.5 text-gray-700">
                                        <ScaleIcon class="inline-block mr-0.5 w-4 h-4" />
                                        {{ element.quantity }}
                                    </p>
                                    <div class="flex mt-3 mb-2 space-x-2">
                                        <Link :href="route(
                                            'console.recipes.prerequisite.edit',
                                            {
                                                recipe: recipe.id,
                                                prerequisite:
                                                    element.id,
                                            },
                                        )
                                            " class="p-2 bg-white rounded-xl border hover:bg-gray-100 focus:ring">
                                        <PencilIcon class="w-4 h-4 text-gray-500" />
                                        </Link>
                                        <form @submit.prevent="
                                            router.delete(
                                                route(
                                                    'console.recipes.prerequisite.destroy',
                                                    {
                                                        recipe: recipe.id,
                                                        prerequisite:
                                                            element.id,
                                                    },
                                                ),
                                                { preserveScroll: true },
                                            )
                                            ">
                                            <button class="p-2 bg-white rounded-xl border hover:bg-gray-100 focus:ring">
                                                <TrashIcon class="w-4 h-4 text-gray-500" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </draggable>
                    <div v-if="recipe.prerequisites.length === 0" class="py-4 px-4 border-t">
                        <span class="text-gray-700">Cette recette n'a pas de prérequis.</span>
                    </div>

                    <footer class="py-4 px-4 border-t">
                        <Link :preserve-scroll="true" :preserve-state="true" :only="['modal']"
                            :class="'rounded-t-xl rounded-b-xl'" :href="route(
                                'console.recipes.prerequisite.create',
                                recipe.id,
                            )
                                " :icon="PlusIcon">
                        <Button :icon="PlusIcon" class="justify-center w-full">
                            Ajouter un prérequis
                        </Button>
                        </Link>
                    </footer>
                </section>

                <div :class="illustrations.length === 0 ? '!mt-0' : ''">
                    <draggable v-model="illustrations" class="space-y-4" ghost-class="opacity-50" item-key="order"
                        tag="ul">
                        <template #item="{
                            element,
                            index,
                        }: {
                            element: Asset;
                            index: number;
                        }">
                            <li class="relative">
                                <ImageUploader :value="element.path" height="h-[12rem]"
                                    class="object-cover object-center w-full bg-gray-50 border" @change="
                                        sync.syncAsset($event, {
                                            asset: element,
                                            onSuccess: (asset: Asset) =>
                                                (illustrations[index] = asset),
                                        })
                                        " />
                                <Input :icon="PhotoIcon" :label="`Légende de l'image ${index + 1}`"
                                    :placeholder="`Légende de l'image ${index + 1}`" :value="element.alt"
                                    class="-mt-0.5 rounded-t-none" first hide-label required type="text" @change="
                                        sync.syncAsset($event, {
                                            asset: element,
                                            onSuccess: (asset: Asset) =>
                                                (illustrations[index] = asset),
                                        })
                                        " />

                                <form @submit.prevent="
                                    sync.removeAsset(element, {
                                        onSuccess: () =>
                                            illustrations.splice(index, 1),
                                    })
                                    ">
                                    <button class="absolute top-4 right-4 p-2 text-gray-500 bg-white rounded-xl">
                                        <TrashIcon class="w-4 h-4" />
                                    </button>
                                </form>
                            </li>
                        </template>
                    </draggable>
                    <SecondaryButton :icon="PlusIcon" class="justify-center mt-4 w-full" @click="
                        sync.createAsset({
                            group: 'illustrations',
                            onSuccess: (asset: Asset) =>
                                illustrations.push(asset),
                        })
                        ">
                        Ajouter une image
                    </SecondaryButton>
                </div>

                <section class="rounded-xl">
                    <ul class="text-sm">
                        <li class="inline-block text-gray-700 bg-white rounded-xl border">
                            <a :href="route('console.recipes.delete', { recipe: recipe.id })">
                                <button class="py-1.5 px-3" type="submit">
                                    <TrashIcon class="inline-block mr-1 -mt-0.5 w-4 h-4" />
                                    Supprimer
                                </button>
                            </a>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="col-span-2">
                <header
                    class="py-3 px-4 bg-gray-50 rounded-xl rounded-b-none border md:flex md:justify-between md:items-center md:py-2">
                    <h5 class="w-full font-semibold">Préparation</h5>
                    <Input v-model="recipe.time_to_prepare" :icon="ClockIcon" class="mt-1 w-full md:mt-0" first
                        hide-label placeholder="(vide)" @input="
                            debounce(
                                () => update('time_to_prepare', $event),
                                200,
                            )
                            " />
                </header>
                <RichText :content="JSON.parse(recipe.content)" :recipes="recipes" buttonsClass="border-b border-x"
                    class="rounded-xl rounded-t-none border-b border-x"
                    @change="debounce(() => update('content', $event), 200)" />
            </div>
        </div>
    </div>

    <InlineModal :show="showSettingsModal" @close="showSettingsModal = false">
        <template #title> Paramètres </template>

        <div class="space-y-6">
            <ModelSearch v-model="recipe.category" :models="categories" label="Catégorie" searchProperty="name"
                @change="update('category_id', $event.id)" />

            <div>
                <h4 class="font-medium text-gray-700">Saison(s)</h4>
                <ul class="flex flex-wrap gap-y-3 gap-x-4 mt-2">
                    <li v-for="tag in seasonTags"
                        class="inline-flex justify-between items-center py-1 px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-xl cursor-pointer"
                        @click="toggleTag">
                        <input :checked="recipe.tags.find((t) => t.id === tag.id)" :value="tag.id"
                            class="w-4 h-4 rounded-xl border-gray-300 pointer-events-none text-brand-600 focus:ring-brand-500"
                            type="checkbox" />
                        <span class="ml-2 select-none">{{
                            {
                                all: "Toutes saisons",
                                winter: "Hiver",
                                spring: "Printemps",
                                summer: "Été",
                                autumn: "Automne",
                            }[tag.name]
                        }}</span>
                    </li>
                </ul>
            </div>

            <Input v-model="recipe.short_title" :icon="TagIcon" label="Titre court" type="text"
                @input="update('short_title', $event)" />

            <Textarea v-model="recipe.description" label="Accroche" name="description"
                @input="debounce(() => update('description', $event), 200)" />Edit.vue

            <div>
                <Checkbox :checked="recipe.uses_sterilization" label="Cet article a une étape de stérilisation"
                    name="uses_sterilization" @input="update('uses_sterilization', $event.target.checked)" />
            </div>
        </div>

        <SecondaryButton :icon="XMarkIcon" class="mt-4" @click="showSettingsModal = false">
            Fermer
        </SecondaryButton>
    </InlineModal>
</template>
