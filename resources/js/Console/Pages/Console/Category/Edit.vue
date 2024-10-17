<script lang="ts" setup>
import Input from "@/Console/Components/Input.vue";
import {Bars3BottomLeftIcon, DocumentIcon} from "@heroicons/vue/24/outline";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Console/Components/Button.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";
import type {Category, Slug} from "@/Console/types";
import Modal from "@/Console/Components/Modal.vue";
import Checkbox from "@/Console/Components/Checkbox.vue";

const props = defineProps<{
    category: Category & { slugs: Slug[] }
}>()

const form = useForm({
    hidden: props.category.hidden,
    name: props.category.name,
    description: props.category.description,
    subtitle: props.category.subtitle,
})

</script>
<template>
    <Modal>
        <template #title>
            Éditer la catégorie
        </template>
        <form @submit.prevent="form.put(route('console.categories.update', { category: category.id }))">
            <Input v-model="form.name" :icon="DocumentIcon" label="Nom" name="name" placeholder="Miam"
                   type="text"/>

            <Input v-model="form.subtitle" :icon="DocumentIcon" label="Sous-titre" name="subtitle" placeholder="c'est vraiment bon!"
                   type="text"/>

            <Input :icon="Bars3BottomLeftIcon" v-model="form.description" label="Description" name="description"
                   placeholder="Description"
                   type="text"/>

            <div class="mt-4">
                <h3 class="font-medium text-gray-700">Slug(s)</h3>

                <ul class="list-disc list-inside" v-if="category.slugs.length">
                    <li v-for="slug in category.slugs">
                        <span class="font-medium text-gray-700">{{ slug.slug }}</span>
                    </li>
                </ul>
                <div v-else>
                    <p class="text-gray-700">Aucun slug.</p>
                </div>
            </div>

            <Checkbox name="hidden" v-model="form.hidden" :checked="form.hidden" label="Cacher pour les visiteurs"/>

            <Button :icon="PlusIcon" class="mt-6 rounded-b-xl" type="submit">
                Mettre à jour
            </Button>
        </form>
    </Modal>

</template>
