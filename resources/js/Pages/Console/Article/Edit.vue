<script lang="ts" setup>
import type {Article, Asset, Recipe} from "@/types";
import {StatusIndicator, useSync} from "@/sync";
import {Head, Link, router} from "@inertiajs/vue3";
import {
    ArrowLeftIcon,
    ArrowPathIcon,
    CheckCircleIcon,
    Cog8ToothIcon,
    PaperAirplaneIcon,
    PhotoIcon,
    XMarkIcon
} from "@heroicons/vue/24/outline";
import axios from "axios";
import Input from "@/Components/Input.vue";
import {ref} from "vue";
import Button from "@/Components/Button.vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import RichText from "@/Components/RichText.vue";
import {debounce} from "@/Components/editor/util";
import Extra from "@/Layouts/Extra.vue";
import InlineModal from "@/Components/InlineModal.vue";
import Textarea from "@/Components/Textarea.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps<{
    article: Article,
    recipes: Recipe[]
}>()

const status = ref<StatusIndicator>(StatusIndicator.Updated)
const errors = ref<Record<string, string>>({})
const showSettingsModal = ref(false)

const sync = useSync('article', props.article.id)
const update = async (property: keyof Article, event: InputEvent | any, retries: number = 10) => {
    if (retries === 0) {
        status.value = StatusIndicator.Error
        return
    }

    status.value = StatusIndicator.Updating

    try {
        const res = await axios.patch(route('console.articles.update', {article: props.article}), {
            [property]: event instanceof InputEvent ? (event.target as HTMLInputElement).value : event
        });

        props.article.publishable = res?.data?.publishable ?? false

        delete errors.value[property]

        status.value = Object.keys(errors.value).length === 0 ? StatusIndicator.Updated : StatusIndicator.Error
    } catch (e) {
        console.error(e)

        if (e?.response?.status === 422) {
            errors.value[property] = e.response.data.errors[property][0]
        }

        status.value = StatusIndicator.Error

        setTimeout(() => update(property, event, retries - 1), retries * 1000)
    }
}
</script>
<template>
    <Head :title="article.title"/>
    <header
        :class="status === StatusIndicator.Error ? 'bg-red-100 text-red-700 border-red-100' : 'text-gray-500 border-gray-300'"
        class="fixed top-0 left-0 w-full bg-white border-b z-30"
    >
        <div class="flex items-center justify-between w-full px-6 py-4">
            <Link :href="route('console.articles.index', { state: props.article.published_at ? 'published': 'unpublished' })">
                <ArrowLeftIcon class="w-6 h-6"/>
            </Link>
            <h4 class="font-bold w-full ml-4 md:ml-0 md:w-auto font-display">{{ article.title }}</h4>
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
                        :class="[article.publishable ? '' : 'opacity-30 cursor-not-allowed']"
                        :disabled="!article.publishable"
                        class="top-1 relative"
                        @click="router.post(route('console.articles.publish', { article: article.id }))">
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
            :value="article.banner?.path"
            class="border-b-0 border bg-gray-50 h-[36rem]"
            @change="sync.syncAsset($event, { group: 'banner:unique', asset: article.banner, onSuccess: (banner: Asset) => props.article.banner = banner })"
        />
        <Input
            :value="article.banner?.alt"
            :icon="PhotoIcon"
            class="rounded-t-none -mt-0.5"
            first
            hide-label
            label="Légende de la bannière"
            placeholder="Légende de la bannière"
            required
            type="text"
            @input="debounce(() => sync.syncAsset($event, {
                group: 'banner:unique',
                onSuccess:  (asset: Asset) => props.article.banner = asset,
                asset: article.banner
            }), 200)"
        />

        <input
            v-model="article.title"
            class="focus:outline-none border-none focus:border-none  focus:ring-0 w-full bg-transparent text-center shadow-none text-5xl font-bold mt-4 md:mt-5"
            placeholder="Titre"
            required
            type="text"
            @input="update('title', $event)"
        />

        <div class="mt-4 max-w-3xl mx-auto">
            <RichText
                :content="JSON.parse(article.content)"
                :recipes="recipes"
                buttons-class="rounded-t-xl border-x border-t"
                class="rounded-b-xl border"
                @change="debounce(() => update('content', $event), 200)"/>
        </div>
    </div>

    <InlineModal :show="showSettingsModal" @close="showSettingsModal = false">
        <template #title>
            Paramètres
        </template>


        <Textarea
            v-model="article.description"
            label="Accroche"
            name="description"
            @input="debounce(() => update('description', $event), 200)"
        />

        <SecondaryButton :icon="XMarkIcon" class="mt-4" @click="showSettingsModal = false">
            Fermer
        </SecondaryButton>
    </InlineModal>
    <Extra/>
</template>
