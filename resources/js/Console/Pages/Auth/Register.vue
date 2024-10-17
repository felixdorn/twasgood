<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import Guest from "@/Console/Layouts/Guest.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid";

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Guest>
        <Head title="Register" />

        <template #title>
            S'inscrire
        </template>

        <form class="mt-8 space-y-6" method="POST" @submit.prevent="submit">
            <div>
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label class="sr-only" for="name">Nom</label>
                        <input id="name" v-model="form.name"
                               autocomplete="name"
                               autofocus
                               class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm"
                               name="name" placeholder="Nom"
                               required
                               type="text"/>
                    </div>
                    <div>
                        <label class="sr-only" for="email-address">Adresse email</label>
                        <input id="email-address" v-model="form.email"
                               autocomplete="email"
                               autofocus
                               class="relative block w-full appearance-none rounded-none border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm"
                               name="email" placeholder="Adresse email"
                               required
                               type="email"/>
                    </div>
                    <div>
                        <label class="sr-only" for="password">Mot de passe</label>
                        <input id="password" v-model="form.password"
                               autocomplete="current-password"
                               class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm"
                               name="password" placeholder="Mot de passe"
                               required
                               type="password"/>
                    </div>
                </div>
                <ul v-if="$page.props.errors" class="text-red-500 mt-2 text-sm text-center">
                    <li v-for="error in Object.keys($page.props.errors)">
                        {{ $page.props.errors[error] }}
                    </li>
                </ul>
            </div>


            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <Link :href="route('login')" class="font-medium text-brand-600 hover:text-brand-500">
                        Déjà inscrit ?
                    </Link>
                </div>
            </div>

            <div>
                <button
                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-brand-600 py-2 px-4 text-sm font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2"
                    type="submit">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-brand-500 group-hover:text-brand-400"/>
            </span>
                    S'inscrire
                </button>
            </div>
        </form>
    </Guest>
</template>
