<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    icon: {
        type: String,
        required: false,
        default: null
    }
});
</script>

<template>

    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto">
        <h1 class="flex items-center text-xl font-semibold text-gray-800">
            <i :class="icon + ' w-6 mr-2 text-gray-600'"></i>
            {{ title }}
        </h1>
    </header>

</template>