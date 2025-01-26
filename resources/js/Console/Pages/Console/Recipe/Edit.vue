<script lang="ts" setup>
import type { Ingredient, Recipe } from "@/Console/types";
import { AdjustmentsHorizontalIcon } from "@heroicons/vue/24/outline";
import type { Asset, Category, Prerequisite, Slug, Tag } from "@/Console/types";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import {
    ArrowLeftIcon,
    ArrowPathIcon,
    CheckCircleIcon,
    ClockIcon,
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

const removePrerequisite = (preReq) => {
    if (!confirm("Confirmez la suppression.")) {
        return;
    }

    router.delete(
        route("console.recipes.prerequisite.destroy", {
            recipe: props.recipe.id,
            prerequisite: preReq.id,
        }),
        { preserveScroll: true },
    );
};

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

const showPrerequisiteModal = ref(false);
const prerequisiteInEdition = ref<Prerequisite>({});
const prerequisiteEditForm = ref({});
const updatePrerequisite = (prerequisite) => {
    prerequisiteInEdition.value = prerequisite;
    prerequisiteEditForm.value = {
        id: prerequisite.id,
        details: prerequisite.details,
        quantity: prerequisite.quantity,
        optional: prerequisite.optional,
        prerequisite: prerequisite.prerequisite,
    };
    showPrerequisiteModal.value = true;
};
const updatePrerequisiteInEdition = async () => {
    sync.updateStatus(StatusIndicator.Updating);

    try {
        const res = await axios.put(
            route("console.recipes.prerequisite.update", {
                prerequisite: prerequisiteEditForm.value.id,
            }),
            {
                details: prerequisiteEditForm.value.details,
                quantity: prerequisiteEditForm.value.quantity,
                optional: prerequisiteEditForm.value.optional,
            },
        );

        delete errors.value["prerequisiteEdit"];

        // We don't care that the write fails, we just want to trigger a compute
        // This is ugly, but I'm fed up now.
        prerequisites.value = prerequisites.value;

        sync.updateStatus(
            Object.keys(errors.value).length === 0
                ? StatusIndicator.Updated
                : StatusIndicator.Error,
        );

        showPrerequisiteModal.value = false;
    } catch (e) {
        console.error(e);

        if (e?.response?.status === 422) {
            // TODO: We should probably show those errors.
            errors.value["prerequisiteEdit"] = {};
            errors.value["prerequisiteEdit"][property] =
                e.response.data.errors[property][0];
        }

        sync.updateStatus(StatusIndicator.Error);
    }
};

const showAddPrerequisisteModal = ref(false);
const newPrerequisiteType = ref("ingredient");
const selectedPrerequisite = ref(null);
const newPrerequisiteForm = ref({});
const storeNewPrerequisite = async () => {
    sync.updateStatus(StatusIndicator.Updating);

    try {
        const res = await axios.post(
            route("console.recipes.prerequisite.store", {
                recipe: props.recipe.id,
                prerequisiteType: newPrerequisiteType.value,
                prerequisite: selectedPrerequisite.value.id,
            }),
            {
                ...newPrerequisiteForm.value,
                id: selectedPrerequisite.value.id,
            },
        );

        delete errors.value["prerequisiteNew"];

        prerequisites.value = prerequisites.value;

        sync.updateStatus(
            Object.keys(errors.value).length === 0
                ? StatusIndicator.Updated
                : StatusIndicator.Error,
        );
    } catch (e) {
        console.error(e);
        if (e?.response?.status === 422) {
            // TODO: We should probably show those errors.
            errors.value["prerequisiteNew"] = {};
            errors.value["prerequisiteNew"][property] =
                e.response.data.errors[property][0];
        }

        sync.updateStatus(StatusIndicator.Error);
    }

    showAddPrerequisisteModal.value = false;
    newPrerequisiteForm.value = {};
    selectedPrerequisite.value = null;
    newPrerequisiteType.value = "ingredient";
};
</script>
<template>

    <Head :title="recipe.title" />
    <header :class="status === StatusIndicator.Error
            ? 'bg-red-100 text-red-700 border-red-100'
            : 'text-gray-500 border-gray-300'
        " class="fixed top-0 left-0 z-30 w-full bg-white border-b">
        <div class="flex justify-between items-center py-2 px-6 w-full">
            <a :href="route('console.recipes.index', {
                state: recipe.published_at
                    ? 'published'
                    : 'unpublished',
            })
                ">
                <ArrowLeftIcon class="w-6 h-6" />
            </a>
            <div class="flex space-x-2">
                <ArrowPathIcon v-if="status === StatusIndicator.Updating"
                    class="w-6 h-6 text-yellow-500 animate-spin" />
                <CheckCircleIcon v-else-if="status === StatusIndicator.Updated" class="w-6 h-6 text-green-500" />
                <XMarkIcon v-else class="w-6 h-6 text-red-500" />
                <h4 class="ml-4 w-full font-bold md:ml-0 md:w-auto font-display">
                    {{ recipe.title }}
                </h4>
            </div>

            <Button :disabled="!recipe.publishable" @click="
                router.post(
                    route('console.recipes.publish', { recipe: recipe.id }),
                )
                ">
                Publier
            </Button>
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
        <Input :value.="recipe.banner?.alt" class="-mt-0.5 rounded-t-none" first hide-label
            label="Légende de la bannière" placeholder="Légende de la bannière" required type="text" @input="
                sync.syncAsset($event, {
                    group: 'banner:unique',
                    asset: props.recipe.banner,
                })
                " />

        <input v-model="recipe.title"
            class="mt-4 w-full text-5xl font-bold text-center bg-transparent border-none shadow-none md:mt-5 focus:border-none focus:ring-0 focus:outline-none"
            placeholder="Titre" required type="text" @input="update('title', $event)" />

        <div class="flex flex-col-reverse mt-4 md:grid md:grid-cols-3 md:gap-x-4">
            <div>
                <div class="-mt-1">
                    <h4 class="font-bold">Saisons</h4>
                    <ul class="flex flex-wrap gap-y-2 gap-x-4 mt-1">
                        <li v-for="tag in seasonTags"
                            class="inline-flex justify-between items-center py-1 px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-xl cursor-pointer"
                            @click="toggleTag">
                            <input :checked="recipe.tags.find((t) => t.id === tag.id)
                                " :value="tag.id"
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
                <div class="mt-4">
                    <h4 class="font-bold">Tags</h4>
                    <ul class="flex flex-wrap gap-y-2 gap-x-4 mt-1">
                        <li v-for="tag in typeTags"
                            class="inline-flex justify-between items-center py-1 px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-xl cursor-pointer"
                            @click="toggleTag">
                            <input :checked="recipe.tags.find((t) => t.id === tag.id)
                                " :value="tag.id"
                                class="w-4 h-4 rounded-xl border-gray-300 pointer-events-none text-brand-600 focus:ring-brand-500"
                                type="checkbox" />
                            <span class="ml-2 select-none">{{ tag.name }}</span>
                        </li>
                    </ul>
                </div>

                <section class="mt-4">
                    <header class="flex justify-between">
                        <h5 class="font-semibold">Prérequis</h5>
                        <button @click="showAddPrerequisisteModal = true" class="underline hover:text-gray-800">
                            Ajouter un prérequis
                        </button>
                    </header>
                    <draggable v-model="prerequisites" ghost-class="bg-gray-100" item-key="order" tag="ul"
                        class="mt-1 border divide-y">
                        <template #item="{ element }">
                            <li class="flex justify-between py-2.5 px-4 hover:bg-gray-50 cursor-grab" :key="element.id">
                                <div class="w-full">
                                    <div class="flex justify-between items-center text-lg">
                                        <component :is="element.type === 'recipe'
                                                ? Link
                                                : 'p'
                                            " :class="{
                                                underline:
                                                    element.type === 'recipe',
                                                'font-bold': true,
                                            }" :href="element.type === 'recipe'
                                                    ? route(
                                                        'console.recipes.edit',
                                                        element.id,
                                                    )
                                                    : undefined
                                                " class="font-semibold">
                                            {{
                                                element.prerequisite[
                                                element.type === "recipe"
                                                    ? "title"
                                                    : "name"
                                                ]
                                            }}

                                            <span v-if="element.details" class="font-normal text-gray-700">
                                                {{ " " + element.details }}
                                            </span>
                                        </component>

                                        <div v-if="element.optional"
                                            class="inline-block mr-0.5 text-base text-gray-500">
                                            <span>Optionnel</span>
                                        </div>
                                    </div>

                                    <p class="mt-0.5 text-gray-900">
                                        {{ element.quantity }}
                                    </p>
                                    <div class="flex mt-1 space-x-4 text-sm">
                                        <button @click="updatePrerequisite(element)" class="text-gray-500 underline">
                                            Éditer
                                        </button>
                                        <form @submit.prevent="
                                            removePrerequisite(element)
                                            ">
                                            <button class="text-gray-500 underline" type="submit">
                                                Supprimer
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
                </section>

                <div class="mt-6">
                    <header class="flex justify-between">
                        <h5 class="font-semibold">Illustrations</h5>
                        <button @click="
                            sync.createAsset({
                                group: 'illustrations',
                                onSuccess: (asset: Asset) =>
                                    illustrations.push(asset),
                            })
                            " class="underline hover:text-gray-800">
                            Ajouter une illustration
                        </button>
                    </header>
                    <draggable v-model="illustrations" class="mt-2 space-y-4" ghost-class="opacity-50" item-key="order"
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
                                <Input :label="`Légende de l'image ${index + 1}`"
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
                    <div v-if="illustrations.length === 0">
                        <p class="py-2 px-4 mt-1 text-gray-700 rounded-xl border">
                            Aucune illustration.
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <ModelSearch first v-model="recipe.category" :models="categories" label="Catégorie"
                        searchProperty="name" @change="update('category_id', $event.id)" />
                </div>

                <div class="space-y-6">
                    <Textarea v-model="recipe.description" label="Accroche" name="description"
                        @input="update('description', $event)" />

                    <div>
                        <Checkbox :checked="recipe.uses_sterilization" label="Cet recette a une étape de stérilisation"
                            name="uses_sterilization" @input="
                                update(
                                    'uses_sterilization',
                                    $event.target.checked,
                                )
                                " />
                    </div>
                </div>
                <div class="mt-6">
                    <a :href="route('console.recipes.delete', {
                        recipe: recipe.id,
                    })
                        " class="text-gray-700 underline">
                        Supprimer
                    </a>
                </div>
            </div>
            <div class="col-span-2">
                <header
                    class="py-3 px-4 bg-gray-50 rounded-xl rounded-b-none border md:flex md:justify-between md:items-center md:py-2">
                    <h5 class="w-full font-semibold">Préparation</h5>
                    <Input v-model="recipe.time_to_prepare" class="mt-1 w-full md:mt-0" first hide-label
                        placeholder="(vide)" @input="update('time_to_prepare', $event.target.value)" />
                </header>
                <RichText :content="JSON.parse(recipe.content)" :recipes="recipes" buttonsClass="border-b border-x"
                    class="rounded-xl rounded-t-none border-b border-x" @change="update('content', $event)" />
            </div>
        </div>
    </div>

    <InlineModal :show="showAddPrerequisisteModal" @close="showAddPrerequisisteModal = false">
        <template #title> Ajouter un prérequis </template>
        <form @submit.prevent="storeNewPrerequisite">
            <div class="flex space-x-4">
                <div class="flex items-center mt-4">
                    <input v-model="newPrerequisiteType" id="ingredient" value="ingredient" name="type" type="radio"
                        class="border-gray-300 checked:bg-brand-600 checked:hover:bg-brand-700 focus:ring-brand-500 focus:checked:bg-brand-600" />
                    <label for="ingredient" class="block ml-1.5 -mt-px select-none">Ingrédient</label>
                </div>
                <div class="flex items-center mt-4">
                    <input v-model="newPrerequisiteType" id="recipe" value="recipe" name="type" type="radio"
                        class="border-gray-300 checked:bg-brand-600 checked:hover:bg-brand-700 focus:ring-brand-500 focus:checked:bg-brand-600" />
                    <label for="recipe" class="block ml-1.5 -mt-px select-none">Recette</label>
                </div>
            </div>
            <div v-if="newPrerequisiteType === 'ingredient'">
                <ModelSearch v-model="selectedPrerequisite" :models="ingredients" label="Ingrédient"
                    search-property="name" />
                <p class="mt-2 text-sm text-gray-700">
                    Vous ne trouvez pas votre ingrédient ?
                    <a :href="route('console.ingredients.create')" class="underline" target="_blank">
                        Ajoutez-le</a>.
                </p>
            </div>
            <div v-else>
                <ModelSearch v-if="newPrerequisiteType === 'recipe'" v-model="selectedPrerequisite" :models="recipes"
                    label="Recette" search-property="title" />
                <p class="mt-2 text-sm text-gray-700">
                    Vous ne trouvez pas la recette ?
                    <a :href="route('console.recipes.create')" class="underline" target="_blank">
                        Ajoutez-la</a>.
                </p>
            </div>
            <div v-if="selectedPrerequisite !== null">
                <Input v-model="newPrerequisiteForm.details" :required="false" label="Détails" placeholder="(émincé)" />

                <Input v-model="newPrerequisiteForm.quantity" label="Quantité" placeholder="1 kilo" />

                <div class="mt-6 mb-7">
                    <Checkbox v-model="newPrerequisiteForm.optional" :checked="newPrerequisiteForm.optional === 1"
                        label="Le prérequis est optionnel" name="optional" />
                </div>

                <Button class="mt-4" type="submit"> Ajouter </Button>
            </div>
        </form>
    </InlineModal>

    <InlineModal :show="showPrerequisiteModal" @close="showPrerequisiteModal = false">
        <template #title>Éditer un prérequis</template>
        <form @submit.prevent="updatePrerequisiteInEdition">
            <Input v-model="prerequisiteEditForm.details" :required="false" label="Détails" placeholder="Détails" />

            <Input v-model="prerequisiteEditForm.quantity" label="Quantité" placeholder="Quantité" required />

            <Checkbox :checked="prerequisiteEditForm.optional" label="Optionnel" name="optional"
                @input="prerequisiteEditForm.optional = $event.target.checked" />
            <p class="pt-4 mt-6 font-semibold border-t text-brand-500">
                Aperçu
            </p>

            <div class="py-2 px-4 mt-1 rounded-xl border">
                <p class="font-semibold">
                    <span :class="{
                        underline: prerequisiteEditForm.type === 'recipe',
                    }" class="mr-1">{{
                            prerequisiteEditForm.prerequisite[
                            prerequisiteEditForm.type === "recipe"
                                ? "title"
                                : "name"
                            ]
                        }}</span>

                    <span v-if="prerequisiteEditForm.details" class="font-normal text-gray-700">
                        {{ prerequisiteEditForm.details }}
                    </span>
                </p>
                <p v-if="prerequisiteEditForm.quantity" class="mt-1 text-gray-700">
                    {{ prerequisiteEditForm.quantity }}
                </p>
            </div>

            <Button class="mt-4">Mettre à jour</Button>
        </form>
    </InlineModal>
</template>
