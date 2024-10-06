<script lang="ts" setup>
import {
    Combobox,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot
} from "@headlessui/vue";
import {Modal} from "momentum-modal";
import AlertHandler from "@/Components/AlertHandler.vue";
import {computed, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import {PlusCircleIcon} from "@heroicons/vue/24/outline";

const paletteOpen = ref(false)
const query = ref('')

if (window) {
    window.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault()
            paletteOpen.value = !paletteOpen.value
            query.value = ''
        }
    })
}

const addTask = () => {
    router.post(
        route('console.tasks.store'),
        {task: query.value},
        {
            onSuccess: () => query.value = ''
        }
    );
}

const tasks = computed(() => query.value === '' ?
    usePage().props.tasks :
    usePage().props.tasks.filter((task) => task.content.toLowerCase().replace(/\s+/g, '').includes(
        query.value.toLowerCase().replace(/\s+/g, '')
    ))
)

const markComplete = function (task) {
    if (query.value !== '' || tasks.value.length === 0) {
        return
    }


    return router.post(route('console.tasks.complete', task.id), {
        onSuccess: () => {
            query.value = ''
        }
    });
}

const noSearch = (e) => {
    e.preventDefault()
}
</script>
<template>
    <Modal/>
    <AlertHandler/>
    <TransitionRoot :show="paletteOpen" appear as="template" @after-leave="query = ''">
        <Dialog as="div" class="relative z-[999]" @close="paletteOpen = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-60 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95"
                                 enter-to="opacity-100 scale-100" leave="ease-in duration-200"
                                 leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                    <DialogPanel
                        class="mx-auto max-w-xl transform rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">

                        <Combobox @update:modelValue="markComplete">
                            <div class="relative" :class="tasks.length > 0 ? 'border-b' : ''">
                                <PlusCircleIcon
                                    aria-hidden="true"
                                    class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400"/>
                                <ComboboxInput
                                    @input="query = $event.target.value"
                                    class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                                    placeholder="Chercher ou ajouter une tâche"
                                    @keydown.ctrl.enter="addTask"
                                    @keydown.enter="noSearch"
                                />
                            </div>
                            <ComboboxOptions v-if="tasks.length > 0"
                                             class="max-h-72 divide-y scroll-py-2 overflow-y-auto text-sm text-gray-800"
                                             static>
                                <ComboboxOption v-for="(task, i) in tasks" :key="task.id" v-slot="{ active }"
                                                :value="task"
                                                as="template">
                                    <li :class="['cursor-default select-none px-4 py-2.5', active && 'bg-brand-600 text-white']">
                                        <span :class="active ? 'text-white/60' : 'text-gray-500'"
                                              class="mr-1.5">{{ i + 1 }}.</span>
                                        <span>
                                            {{ task.content }}
                                        </span>
                                    </li>
                                </ComboboxOption>
                            </ComboboxOptions>
                            <p v-if="query !== '' && tasks.length === 0" class="p-4 text-sm text-gray-500">
                                Aucune tâche ne correspond à votre recherche.
                            </p>


                            <div class="flex flex-wrap items-center bg-gray-50 rounded-b-xl py-2.5 px-4 text-xs text-gray-700">
                                Tapez
                                <kbd :class="['mx-1 flex h-5 w-5 items-center justify-center rounded border bg-white sm:mx-1']">↵</kbd>
                                <span>pour finir une tâche, ou</span>
                                <kbd class="mx-1 flex h-5 pt-0.5 w-[4.5rem] items-center justify-center rounded border bg-white sm:mx-1">Ctrl + ↵</kbd>
                                pour ajouter une tâche.
                            </div>
                        </Combobox>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
