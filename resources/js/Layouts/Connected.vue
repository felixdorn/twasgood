<script lang="ts" setup>
import {ref} from 'vue'
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    ArrowTopRightOnSquareIcon,
    Bars3BottomLeftIcon,
    ClipboardDocumentCheckIcon,
    FolderIcon,
    HashtagIcon,
    NewspaperIcon,
    QueueListIcon,
    ShoppingCartIcon,
    TagIcon,
    ViewColumnsIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

import {MagnifyingGlassIcon} from '@heroicons/vue/20/solid'
import {Head, Link, router} from "@inertiajs/vue3";
import Extra from "@/Layouts/Extra.vue";
import axios from "axios";

const getIcon = (name: string) => {
    return {
        newspaper: NewspaperIcon,
        cart: ShoppingCartIcon,
        folder: FolderIcon,
        tag: TagIcon,
        hashtag: HashtagIcon,
        clipboard: ClipboardDocumentCheckIcon,
        "queue-list": QueueListIcon,
        "external": ArrowTopRightOnSquareIcon,
        "view-columns": ViewColumnsIcon,
    }[name]
}

const userNavigation = ref([])

const sidebarOpen = ref(false)

const props = withDefaults(defineProps<{
    title: string
    width?: string
}>(), {
    width: 'max-w-2xl xl:max-w-4xl xl:max-w-5xl 2xl:max-w-7xl'
})

const searchQuery = ref("")
const searchResults = ref([])
const search = (v: string) => {
    searchQuery.value = v;

    axios.get(route('api.search', {query: v})).then((response) => {
        searchResults.value = response.data;
    })
}
</script>
<template>
    <Head :title="`${title}`"/>
    <div>
        <TransitionRoot :show="sidebarOpen" as="template">
            <Dialog as="div" class="relative z-40 md:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0" enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                     enter-from="-translate-x-full" enter-to="translate-x-0"
                                     leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                     leave-to="-translate-x-full">
                        <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-brand-700 pt-5 pb-4">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                             enter-to="opacity-100" leave="ease-in-out duration-300"
                                             leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute top-0 right-0 -mr-12 pt-2">
                                    <button
                                        class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                        type="button"
                                        @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon aria-hidden="true" class="h-6 w-6 text-white"/>
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="flex flex-shrink-0 items-center px-4">
                                <img alt="Your Company"
                                     class="h-8 w-auto"
                                     src="https://tailwindui.com/img/logos/mark.svg?color=brand&shade=300"/>
                            </div>
                            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                                <nav class="space-y-1 px-2">
                                    <Link v-for="item in navigation" :key="item.name"
                                          :class="[item.current ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-600', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']"
                                          :href="item.href">

                                        <component :is="item.icon" aria-hidden="true"
                                                   class="mr-4 h-6 w-6 flex-shrink-0 text-brand-300"/>
                                        {{ item.name }}
                                    </Link>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                    <div aria-hidden="true" class="w-14 flex-shrink-0">
                        <!-- Dummy element to force sidebar to shrink to fit close icon -->
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex flex-grow flex-col overflow-y-auto bg-brand-700 pt-5">
                <Link :href="route('console.index')"
                      class="flex flex-shrink-0 items-center px-4 text-white text-md font-bold">
                    faireplusachetermoins.fr
                </Link>
                <div class="mt-5 flex flex-1 flex-col">
                    <nav class="flex-1 space-y-1 px-2 pb-4 px-4">
                        <ul class="space-y-6">
                            <li>
                                <Link
                                    :href="route('welcome')"
                                    class="hover:bg-brand-500 p-2 font-medium rounded-md text-sm text-brand-100 bg-brand-600 flex items-center">
                                    <ArrowTopRightOnSquareIcon class="mr-3 h-6 w-6 flex-shrink-0 text-brand-300"
                                                               aria-hidden="true"/>
                                    Voir la version publique
                                </Link>
                            </li>
                            <li v-for="section in $page.props.navigation">
                                <div class="text-brand-200 leading-6 font-semibold text-xs">{{ section.name }}</div>

                                <ul role="list" class="mt-1">
                                    <li v-for="item in section.items">
                                        <Link :key="item.name" :href="item.url"
                                              :class="[item.active ? 'bg-brand-800 text-white' : 'text-brand-100 hover:bg-brand-600', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
                                            <component :is="getIcon(item.icon)"
                                                       class="mr-3 h-6 w-6 flex-shrink-0 text-brand-300"
                                                       aria-hidden="true"/>
                                            {{ item.name }}
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


        <div class="flex flex-1 flex-col md:pl-64">
            <div class="z-10 flex h-16 flex-shrink-0 bg-white"
                 :class="[(searchResults.length || searchQuery.length)  ? '' : 'shadow']">
                <button
                    class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500 md:hidden"
                    type="button"
                    @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3BottomLeftIcon aria-hidden="true" class="h-6 w-6"/>
                </button>
                <div class="flex flex-1 justify-between px-4">
                    <div class="flex flex-1">
                        <form action="#" class="flex w-full md:ml-0" method="GET">
                            <label class="sr-only" for="search-field">Recherche</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                                    <MagnifyingGlassIcon aria-hidden="true" class="h-5 w-5"/>
                                </div>
                                <input id="search-field"
                                       @input="search($event.target.value)"
                                       class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                                       name="search" placeholder="Rechercher une recette" type="search"/>
                            </div>
                        </form>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative ml-3">
                            <div>
                                <MenuButton
                                    class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                    <span class="sr-only">Open user menu</span>

                                    <div
                                        class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white font-semibold text-xs">
                                        <span>
                                            {{ $page.props.auth.user.initials }}
                                        </span>
                                    </div>
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                           :href="item.href">{{
                                                item.name
                                            }}</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <form @submit.prevent="router.post(route('logout'))">
                                            <button
                                                :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 text-left w-full']"
                                                type="submit">
                                                Déconnexion
                                            </button>
                                        </form>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>


            <div class="w-full bg-white px-4 shadow-sm border-t top-16"
                 v-if="searchResults.length || searchQuery.length">
                <div class="py-4">
                    <div v-if="searchResults.length">
                        <h3 class="font-medium text-gray-700">Résultats</h3>
                        <!--                    <div v-if="false" class="flex  items-center justify-center">
                                                <div
                                                    aria-hidden="true"
                                                    class="inline-block h-8 w-8 animate-spin rounded-full border-[3px] border-solid border-current border-r-transparent align-[-0.125em] text-gray-400"
                                                    />
                                                <span role="status" class="sr-only">Loading...</span>
                                            </div>
                            -->
                        <ul class="mt-4 space-y-6">
                            <li v-for="result in searchResults">
                                <Link :href="route('console.recipes.edit', { recipe: result}) "
                                      class="flex items-center hover:bg-gray-100 py-2 px-4 -my-2 -mx-4 rounded-xl">
                                    <img :src="`/storage/${result.banner.pixel_path}`" :alt="result.banner.alt"
                                         :title="result.banner.alt"
                                         class="w-12 h-12 object-cover object-center rounded-xl"/>

                                    <div class="ml-4">
                                        <span class="font-semibold block -mt-px">{{ result.title }}</span>
                                        <span class="block text-gray-700 max-w-lg truncate mt-0.5">{{
                                                result.description
                                            }}</span>
                                    </div>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p class="text-lg text-gray-700">Aucun résultat pour « {{ searchQuery }} »</p>
                    </div>
                </div>
            </div>
            <main>
                <div class="py-6">
                    <div class="mx-auto px-4 sm:px-6 md:px-8 flex justify-between center">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ title }}</h1>

                        <slot name="header"/>
                    </div>
                    <div class="mx-auto px-4 sm:px-6 md:px-8">
                        <slot/>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <Extra/>
</template>
