<script lang="ts" setup>
import {LockClosedIcon} from '@heroicons/vue/20/solid'
</script>
<template>
    <div class="flex min-h-full mt-12 lg:mt-24   justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <span class="text-xl text-emerald-600  inline-block mx-auto text-center font-bold leading-none">
                    Faire + Acheter -
                </span>
                <h2 class="mt-1 text-center text-3xl font-bold tracking-tight text-gray-900">
                    <slot name="title"/>
                </h2>
            </div>

            <slot />
        </div>
    </div>
</template>
