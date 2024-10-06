<script lang="ts" setup>
import Input from "@/Components/Input.vue";
import {PhotoIcon} from "@heroicons/vue/24/outline";

const props = defineProps<{
    value?: string,
    error?: string,
    height?: string,
    class: string
}>()

defineEmits<{ (event: 'change', file: File): void }>()
</script>
<template>
    <div>
        <div @click="$refs.dialog.click()">
            <img v-bind="$attrs"
                 v-if="value && !error" :src="`/storage/${value}`" alt="" class="rounded-t-xl w-full object-top object-cover"   />
            <div
                v-else
                :class="height ? height : 'h-[507px]'"
                class="cursor-pointer border border-gray-300 rounded-t-xl flex items-center justify-center"
            >
                <div class="flex flex-col items-center justify-center">
                    <PhotoIcon class="w-12 h-12 text-gray-400" />

                    <p v-if="!error" class="text-gray-400 font-bold mt-4">Appuyez pour ajouter une image.</p>
                    <p v-if="error" class="text-red-500 font-bold mt-4">{{ error }}</p>
                </div>
            </div>
        </div>
        <label ref="dialog" class="hidden">
            <input
                v-bind:name="$attrs.name"
                class="hidden" type="file" @change="$emit('change', $event.target.files[0])"
            />
        </label>
    </div>
</template>
