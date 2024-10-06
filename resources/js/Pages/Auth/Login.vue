<script lang="ts" setup>
import {useForm, Link, Head} from "@inertiajs/vue3";
import Guest from "@/Layouts/Guest.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <Guest>
        <Head title="Se connecter"/>

        <template #title>
            Se connecter
        </template>

        <form class="mt-8 space-y-6" method="POST" @submit.prevent="submit">
            <div>
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label class="sr-only" for="email-address">Adresse email</label>
                        <input id="email-address" v-model="form.email"
                               autocomplete="email"
                               autofocus
                               class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm"
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
                <div class="flex items-center">
                    <input id="remember-me"
                           v-model="form.remember"
                           class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                           name="remember"
                           type="checkbox"/>
                    <label class="ml-2 block text-sm text-gray-900" for="remember-me">Se souvenir de moi</label>
                </div>

                <div class="text-sm">
                    <Link :href="route('password.request')" class="font-medium text-brand-600 hover:text-brand-500">
                        Mot de passe oublié ?
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
                    Se connecter
                </button>
            </div>
        </form>
    </Guest>
</template>
