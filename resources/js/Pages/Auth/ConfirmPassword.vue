<script lang="ts" setup>
import {Head, useForm} from '@inertiajs/vue3';
import Guest from "@/Layouts/Guest.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import {ShieldCheckIcon} from "@heroicons/vue/20/solid";
import {KeyIcon} from "@heroicons/vue/24/solid";

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Guest>
        <Head title="Confirm Password"/>

        <template #title>
            Confirmer le mot de passe
        </template>

        <form @submit.prevent="submit">
            <Input v-model="form.password"
                   :icon="KeyIcon" autocomplete="current-password" autofocus label="Mot de passe"
                   name="password" placeholder="Mot de passe" type="password"
                   required/>

            <Button :icon="ShieldCheckIcon" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="mt-4">
                Confirmer
            </Button>
        </form>
    </Guest>
</template>
