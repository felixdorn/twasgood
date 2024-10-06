<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Guest from "@/Layouts/Guest.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import {EnvelopeIcon, KeyIcon} from "@heroicons/vue/24/solid";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <Guest>
        <Head title="Reset Password" />

        <template #title>
            Réinitialisation du mot de passe
        </template>

        <form @submit.prevent="submit">
            <Input :icon="EnvelopeIcon" name="email" v-model="form.email" required autocomplete="email" autofocus placeholder="Email" />
            <Input :icon="KeyIcon" name="password" type="password" v-model="form.password" required autocomplete="new-password" placeholder="Mot de passe" />
            <Input :icon="KeyIcon" name="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" placeholder="Mot de passe (confirmation)" />


            <div class="flex items-center justify-end mt-4">
                <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Réinitialiser le mot de passe
                </Button>
            </div>
        </form>
    </Guest>
</template>
