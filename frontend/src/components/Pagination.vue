<script setup>
import { defineProps, defineEmits, computed } from "vue";

const props = defineProps({
    meta: { type: Object, required: true },
});

const emit = defineEmits(["page-changed"]);

// Array of page numbers
const pages = computed(() => {
    const arr = [];
    for (let i = 1; i <= props.meta.last_page; i++) {
        arr.push(i);
    }
    return arr;
});

const changePage = (page) => {
    if (page >= 1 && page <= props.meta.last_page) {
        emit("page-changed", page);
    }
};
</script>

<template>
    <div class="flex items-center justify-center gap-2 mt-4">
        <button v-for="page in pages" :key="page" @click="changePage(page)" :class="[
            'px-3 py-1 rounded border',
            page === meta.current_page ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]">
            {{ page }}
        </button>
    </div>
</template>
