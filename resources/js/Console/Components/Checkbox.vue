<script lang="ts" setup>
import {computed} from "vue";

const props = defineProps<{
    name: string,
    label?: string,
    checked?: boolean;
    first?: boolean
}>()

const emit = defineEmits(['update:checked', 'input']);

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);

    },
});
</script>
<template>
    <div class="flex items-center" :class="{'mt-4': !first}">
        <input
            :id="name"
            v-model="proxyChecked"
            :checked="checked"
            class="border-gray-300 rounded text-brand-600 shadow-sm focus:border-brand-300 focus:ring-2 focus:ring-offset-0 focus:ring-brand-200 focus:ring-opacity-50 transition ease-in duration-100" :name="name" type="checkbox"
            v-bind="$attrs"
            @change="$emit('input', $event)"
        >
        <label class="ml-2 text-gray-900 leading-none" v-if="label" :for="name">{{ label }}</label>
    </div>
</template>
