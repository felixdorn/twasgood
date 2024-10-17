<script lang="ts" setup>
import Connected from "@/Console/Layouts/Connected.vue";
import Button from "@/Console/Components/Button.vue";
import {PlusCircleIcon, ArchiveBoxXMarkIcon} from "@heroicons/vue/24/outline";
import {Link, useForm} from "@inertiajs/vue3";
import {Prerequisite, Recipe, Section} from "@/Console/types";
import EmptyState from "@/Console/Components/EmptyState.vue";
import {DraggableIcon} from "@/Console/Components/editor/icons";
import draggable from "vuedraggable";
import {computed} from "vue";
import {useSync} from "@/Console/sync";

const props = defineProps<{
  sections: (Section & {
    recipes: Recipe[]
  })[]
}>()

const sectionsBuf = computed<Section[]>(() => props.sections)
const sections = computed({
  get: () => props.sections,
  set: (values) => {
    const form = useForm({
      sections: values.map((v) => v.id)
    })

    // Happy thoughts
    sectionsBuf.value = values

    form.put(route('console.order-sections'), {preserveScroll: true})
  }
})
</script>
<template>
  <Connected title="Parties">
    <template #header>
      <Link :href="route('console.sections.create')">
        <Button :icon="PlusCircleIcon">
          Nouvelle partie
        </Button>
      </Link>
    </template>

    <draggable v-if="sections.length > 0" v-model="sections" class="mt-12">
      <template #item="{ element, index}">
        <Link :href="route('console.sections.edit', element.id)"
              class="group flex justify-between group border-x border-b first:border-t first:rounded-t-xl last:rounded-b-xl bg-white px-6 py-4">
          <h3 class="text-xl font-medium group-hover:underline">
            <DraggableIcon class="inline-block w-5 h-5 mr-2 -mt-1"/>
            {{ element.title }}
            <span v-if="element.force_hide"
                  class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                            Cachée
                       </span>
          </h3>
          <button :href="route('console.sections.edit', { section: element.id })" class="group-hover:underline">
            Éditer &rarr;
          </button>
        </Link>
      </template>
    </draggable>
    <div v-else class="text-center mt-6">
      <EmptyState :icon="ArchiveBoxXMarkIcon" description="Créez une partie pour commencer."
                  title="Aucune partie"/>
    </div>
  </Connected>
</template>
