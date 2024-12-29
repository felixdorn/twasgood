<script lang="ts" setup>
import Connected from "@/Console/Layouts/Connected.vue";
import Button from "@/Console/Components/Button.vue";
import { PlusCircleIcon, ArchiveBoxXMarkIcon } from "@heroicons/vue/24/outline";
import { Link, useForm } from "@inertiajs/vue3";
import { Prerequisite, Recipe, Section } from "@/Console/types";
import EmptyState from "@/Console/Components/EmptyState.vue";
import { DraggableIcon } from "@/Console/Components/editor/icons";
import draggable from "vuedraggable";
import { computed } from "vue";
import { useSync } from "@/Console/sync";

const props = defineProps<{
    sections: (Section & {
        recipes: Recipe[];
    })[];
}>();

const sectionsBuf = computed<Section[]>(() => props.sections);
const sections = computed({
    get: () => props.sections,
    set: (values) => {
        const form = useForm({
            sections: values.map((v) => v.id),
        });

        // Happy thoughts
        sectionsBuf.value = values;

        form.put(route("console.order-sections"), { preserveScroll: true });
    },
});
</script>
<template>
    <Connected title="Parties">
        <template #header>
            <a :href="route('console.sections.create')">
                <Button :icon="PlusCircleIcon"> Nouvelle partie </Button>
            </a>
        </template>

        <draggable v-if="sections.length > 0" v-model="sections" class="mt-12">
            <template #item="{ element, index }">
                <Link :href="route('console.sections.edit', element.id)"
                    class="flex justify-between py-4 px-6 bg-white border-b first:rounded-t-xl first:border-t last:rounded-b-xl group border-x">
                <h3 class="text-xl font-medium group-hover:underline">
                    <DraggableIcon class="inline-block mr-2 -mt-1 w-5 h-5" />
                    {{ element.title }}
                    <span v-if="element.force_hide"
                        class="inline-flex items-center py-0.5 px-2.5 ml-2 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                        Cachée
                    </span>
                </h3>
                <button :href="route('console.sections.edit', {
                    section: element.id,
                })
                    " class="group-hover:underline">
                    Éditer &rarr;
                </button>
                </Link>
            </template>
        </draggable>
        <div v-else class="mt-6 text-center">
            <EmptyState :icon="ArchiveBoxXMarkIcon" description="Créez une partie pour commencer."
                title="Aucune partie" />
        </div>
    </Connected>
</template>
