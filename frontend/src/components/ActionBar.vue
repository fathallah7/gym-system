<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    buttonText: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Search...'
    },
    toRoute: {
        type: String,
        required: true,
    }
});
</script>


<template>

    <div class="mb-3 flex items-center justify-between gap-4">
        <input type="text" :placeholder="placeholder"
            class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black" />

        <RouterLink :to="toRoute"
            class="relative bg-gray-800 text-white px-6 py-2 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
            {{ buttonText }}
        </RouterLink>
    </div>


</template>