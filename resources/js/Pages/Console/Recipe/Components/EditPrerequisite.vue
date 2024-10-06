<script lang="ts" setup>
import type {Ingredient, Prerequisite, Recipe} from "@/types";
import {AdjustmentsHorizontalIcon, ChartBarIcon, PlusIcon} from "@heroicons/vue/24/outline";
import Checkbox from "@/Components/Checkbox.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import InlineModal from "@/Components/InlineModal.vue";
import {useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps<{
    prerequisite: Prerequisite,
}>()

const form = useForm({
    details: props.prerequisite.details,
    quantity: props.prerequisite.quantity,
    optional: props.prerequisite.optional,
})
const update = () => form.put(route('console.recipes.prerequisite.update', {
    prerequisite: props.prerequisite.id,
}))
</script>
<template>
    <Modal>
        <template #title> Éditer un prérequis</template>
        <form @submit.prevent="update">
            <Input
                v-model="form.details"
                :icon="AdjustmentsHorizontalIcon"
                :required="false"
                label="Détails"
                placeholder="Détails"
            />

            <Input
                v-model="form.quantity"
                :icon="ChartBarIcon"
                label="Quantité"
                placeholder="Quantité"
                required
            />

            <Checkbox :checked="form.optional"
                      label="Optionnel"
                      name="optional" @input="form.optional = $event.target.checked"/>
            <p class="text-brand-500 font-semibold border-t mt-6 pt-4">Aperçu</p>

            <div class="border mt-1 py-2 px-4 rounded-xl">
                <p class="font-semibold">
                        <span :class="{'underline': prerequisite.type === 'recipe'}"
                              class="mr-1">{{
                                {
                                    'recipe': (prerequisite.prerequisite as Recipe).title,
                                    'ingredient': (prerequisite.prerequisite as Ingredient).name,
                                }[prerequisite.type]
                            }}</span>


                    <span v-if="form.details" class="font-normal text-gray-700">
                            {{ form.details }}
                        </span>
                </p>
                <p v-if="form.quantity" class="mt-1 text-gray-700">
                    {{ form.quantity }}
                </p>
            </div>

            <Button :icon="PlusIcon" class="mt-4">Mettre à jour</Button>
        </form>
    </Modal>

</template>
