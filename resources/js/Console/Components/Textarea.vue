<script lang="ts" setup>

import {ref} from "vue";

const props = withDefaults(defineProps<{
    name: string,
    label: string,
    first?: boolean,
    hideLabel?: boolean,
    errors?: Record<string, string>,
    modelValue?: string,
}>(), {
    first: false,
    hideLabel: false,
    errors: null,
})

const value = ref(props.modelValue)

</script>
<template>
    <div :class="{'mt-4': !first}">
        <label v-if="!hideLabel" :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <div :class="{ 'mt-1': !hideLabel }" class="relative shadow-sm grow-wrap" :data-replicated-value="value">
            <textarea
                :id="name"
                :aria-label="hideLabel ? label : null"
                :name="name"
                class="rounded-xl  focus:ring-brand-500 focus:border-brand-500 block w-full focus:outline-none resize-none sm:text-sm border-gray-300 py-2 border"
                v-bind="$attrs"
                @input="$emit('update:modelValue', $event.target.value); value = $event.target.value"
            >{{ modelValue }}</textarea>
        </div>
        <p v-if="(errors ?? $page.props.errors)[name]" class="mt-2 font-semibold text-sm text-red-600">
            {{ (errors ?? $page.props.errors)[name] }}</p>
    </div>
</template>
<style>
/* https://css-tricks.com/the-cleanest-trick-for-autogrowing-textareas/ */
.grow-wrap {
    /* easy way to plop the elements on top of each other and have them both sized based on the tallest one's height */
    display: grid;
}
.grow-wrap::after {
    /* Note the weird space! Needed to prevent jumpy behavior */
    content: attr(data-replicated-value) " ";

    /* This is how textarea text behaves */
    white-space: pre-wrap;

    /* Hidden from view, clicks, and screen readers */
    visibility: hidden;
}
.grow-wrap > textarea {
    /* You could leave this, but after a user resizes, then it ruins the auto sizing */
    resize: none;

    /* Firefox shows scrollbar on growth, you can hide like this. */
    overflow: hidden;
}
.grow-wrap > textarea,
.grow-wrap::after {
    /* Identical styling required!! */
    @apply block w-full sm:text-sm border-gray-300 py-2 border;
    /* Place on top of each other */
    grid-area: 1 / 1 / 2 / 2;
}

.grow-wrap > textarea:focus {
    @apply ring-0 border-brand-500;
}
</style>
