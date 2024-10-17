<script lang="ts" setup>
import Modal from "@/Console/Components/Modal.vue";
import Input from "@/Console/Components/Input.vue";
import {DocumentIcon, PlusCircleIcon} from "@heroicons/vue/24/outline";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Console/Components/Button.vue";

const form = useForm({
    title: ''
})
</script>
<template>
    <Modal>
        <template #title>
            Créer une nouvelle partie
        </template>

        <form @submit.prevent="form.post(route('console.sections.store'))">
            <Input
                :icon="DocumentIcon"
                label="Titre"
                v-model="form.title"

                placeholder="5 recettes pleines de fraîcheur"
            />

            <Button :icon="PlusCircleIcon" class="mt-6">
                Créer
            </Button>
        </form>
    </Modal>
</template>
