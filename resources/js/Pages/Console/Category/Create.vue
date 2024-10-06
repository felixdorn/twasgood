<script lang="ts" setup>
import Input from "@/Components/Input.vue";
import {DocumentIcon} from "@heroicons/vue/24/outline";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";
import Modal from "@/Components/Modal.vue";

const form = useForm({
    name: "",
})

</script>
<template>
    <Modal>
        <template #title>
            Créer une catégorie
        </template>

        <form @submit.prevent="form.post(route('console.categories.store'))">
            <Input v-model="form.name" :icon="DocumentIcon" label="Nom" name="name" placeholder="Miam"
                   type="text"/>

            <Button :icon="PlusIcon" class="mt-6 rounded-b-xl" type="submit">
                Créer
            </Button>
        </form>
    </Modal>
</template>
