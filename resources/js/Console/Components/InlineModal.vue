<script setup lang="ts">
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/20/solid";
import { computed, ref } from "vue";

const props = defineProps<{
    show: boolean;
    width?: string;
}>();

const show = computed(() => props.show);

defineEmits<{
    close: () => void;
}>();
</script>
<template>
    <TransitionRoot :show="show" appear as="template">
        <Dialog as="div" class="relative z-40" @close="$emit('close')">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 transition-opacity bg-black/75" />
            </TransitionChild>

            <div class="overflow-y-auto fixed inset-0">
                <div class="flex justify-center items-center p-4 min-h-full text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel :class="width ? width : 'max-w-lg'"
                            class="p-6 w-full text-left align-middle bg-white rounded-2xl shadow-xl transition-all transform">
                            <div class="flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    <slot name="title" />
                                </DialogTitle>

                                <button @click="$emit('close')">
                                    <XMarkIcon class="w-6 h-6 text-gray-400 hover:text-gray-500" />
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
