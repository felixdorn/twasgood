<script lang="ts" setup>
import Modal from "@/Components/Modal.vue";
import Input from "@/Components/Input.vue";
import {DocumentIcon} from "@heroicons/vue/24/outline";
import {useForm} from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";

const form = useForm({
    title: "",
})
</script>
<template>
    <Modal>
        <template #title>
            Créer un article
        </template>

        <form @submit.prevent="form.post(route('console.articles.store'))">
            <Input v-model="form.title" :icon="DocumentIcon" autofocus label="Titre" name="title"
                   placeholder="Mon titre" type="text"/>

            <Button :icon="PlusIcon" class="mt-6" type="submit">
                Créer
            </Button>
        </form>

    </Modal>
</template>
