<script setup>
import {computed, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import {XMarkIcon} from "@heroicons/vue/20/solid";
import {CheckCircleIcon} from "@heroicons/vue/24/outline";
const alert = computed(() => usePage().props.flash.alert);

const showAlert = ref(true)

setTimeout(() => {
    showAlert.value = false
}, 5000)
</script>
<template>
    <div v-if="alert" aria-live="assertive" class="w-full fixed bottom-0 right-0 px-4 py-6  sm:p-6">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <transition enter-active-class="transform ease-out duration-300 transition"
                        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                        leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                <div v-if="showAlert"
                     class="max-w-sm w-full bg-white shadow-lg z-50 rounded-xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center" v-if="alert.type === 'undo'">
                            <form class="w-0 flex-1 flex justify-between"
                                  @submit.prevent="router.post(alert.restore_url)">
                                <p class="w-0 flex-1 text-sm font-medium text-gray-900">{{ alert.message }}</p>
                                <button class="ml-3 flex-shrink-0 bg-white rounded-md text-sm font-medium text-brand-600 hover:text-brand-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                                        type="submit">
                                    Annuler
                                </button>
                            </form>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button
                                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-start" v-else-if="alert.type === 'success'">
                            <div class="flex-shrink-0">
                                <CheckCircleIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">{{ alert.message }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ alert.sub_message }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="showAlert = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>
