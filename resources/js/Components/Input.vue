<script lang="ts" setup>
import {PropType} from "vue";
import {usePage} from "@inertiajs/vue3";

defineProps({
    name: String,
    label: String,
    icon: Function,
    type: String,
    first: {type: Boolean, default: false},
    modelValue: String,
    hideLabel: {type: Boolean, default: false},
    errors: {
        type: Object as PropType<Record<string, string>>,
        default: null
     },
    required: {
        type: Boolean,
        default: true
    }
})
</script>
<template>
    <div :class="{'mt-4': !first}">
        <label v-if="!hideLabel" :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <div :class="{ 'mt-1': !hideLabel }" class="relative rounded-xl shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <component :is="icon" class="h-5 w-5 text-gray-400" />
            </div>
            <input
                :id="name"
                :aria-label="hideLabel ? label : null"
                :name="name"
                :type="type"
                :value="modelValue ?? $attrs.value"
                class="focus:ring-brand-500 focus:border-brand-500 block w-full focus:outline-none pl-10 sm:text-sm border-gray-300 rounded-xl py-2 border"
                :required="required"
                v-bind="$attrs"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
        <p v-if="(errors ?? $page.props.errors)[name]" class="mt-2 font-semibold text-sm text-red-600">{{ (errors ?? $page.props.errors)[name] }}</p>
    </div>
</template>
