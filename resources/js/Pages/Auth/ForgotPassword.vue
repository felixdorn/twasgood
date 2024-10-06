<script lang="ts" setup>
import {Head, useForm} from '@inertiajs/vue3';
import Guest from "@/Layouts/Guest.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import {EnvelopeIcon} from "@heroicons/vue/24/solid";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Guest>
        <Head title="Mot de passe oublié"/>
        <template #title>
            Réinitialiser le mot de passe
        </template>


        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <Input v-model="form.email" :icon="EnvelopeIcon" autocomplete="email" autofocus label="Email" name="email"
                   placeholder="john@example.com" required/>

            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="mt-5">
                Envoyer le lien de réinitialisation du mot de passe
            </Button>
        </form>
    </Guest>
</template>
