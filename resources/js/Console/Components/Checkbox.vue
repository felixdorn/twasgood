<script lang="ts" setup>
import { computed } from "vue";

const props = defineProps<{
    name: string;
    label?: string;
    checked?: boolean;
    first?: boolean;
}>();

const emit = defineEmits(["update:checked", "input"]);

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>
<template>
    <div class="flex items-center" :class="{ 'mt-4': !first }">
        <input :id="name" v-model="proxyChecked" :checked="checked"
            class="border-gray-300 shadow-sm transition duration-100 ease-in focus:ring-2 focus:ring-opacity-50 focus:ring-offset-0 text-brand-600 focus:border-brand-300 focus:ring-brand-200"
            :name="name" type="checkbox" v-bind="$attrs" @change="$emit('input', $event)" />
        <label class="ml-2 leading-none text-gray-900 select-none" v-if="label" :for="name">{{ label }}</label>
    </div>
</template>
