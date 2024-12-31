<script lang="ts" setup>
import { PropType } from "vue";

defineProps({
    name: String,
    label: String,
    type: String,
    first: { type: Boolean, default: false },
    modelValue: String,
    hideLabel: { type: Boolean, default: false },
    errors: {
        type: Object as PropType<Record<string, string>>,
        default: null,
    },
    required: {
        type: Boolean,
        default: true,
    },
});
</script>
<template>
    <div :class="{ 'mt-4': !first }">
        <label v-if="!hideLabel" :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <div :class="{ 'mt-1': !hideLabel }" class="relative rounded-xl shadow-sm">
            <input :id="name" :aria-label="hideLabel ? label : null" :name="name" :type="type"
                :value="modelValue ?? $attrs.value"
                class="block py-2 pl-4 w-full rounded-xl border border-gray-300 sm:text-sm focus:outline-none focus:ring-brand-500 focus:border-brand-500"
                :required="required" v-bind="$attrs" @input="$emit('update:modelValue', $event.target.value)" />
        </div>
        <p v-if="(errors ?? $page.props.errors)[name]" class="mt-2 text-sm font-semibold text-red-600">
            {{ (errors ?? $page.props.errors)[name] }}
        </p>
    </div>
</template>
