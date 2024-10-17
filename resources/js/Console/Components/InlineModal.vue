<script setup lang="ts">
// keep in sync with Modal.vue
import {TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle} from "@headlessui/vue"
import { XMarkIcon} from "@heroicons/vue/20/solid";
import {computed, ref} from "vue";

const props = defineProps<{
    show: boolean,
    width?: string,
}>()

const show = computed( () => props.show)

defineEmits<{
    close: () => void
}>()
</script>
<template>
    <TransitionRoot :show="show" appear as="template">
        <Dialog as="div" class="relative z-40" @close="$emit('close')">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            :class="width ? width : 'max-w-lg'"
                            class="w-full transform rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <div class="flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    <slot name="title" />
                                </DialogTitle>

                                <button @click="$emit('close')">
                                    <XMarkIcon class="h-6 w-6 text-gray-400 hover:text-gray-500" />
                                </button>
                            </div>

                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
