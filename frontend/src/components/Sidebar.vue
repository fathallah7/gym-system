<script setup>
import { RouterLink } from 'vue-router'
import SidebarLinks from './SidebarLinks.vue'

const props = defineProps({
    isSidebarOpen: Boolean
})

const emit = defineEmits(['close-sidebar'])

function handleLinkClick() {
    if (window.innerWidth < 1024) {
        emit('close-sidebar')
    }
}
</script>

<template>
    <aside :class="[
        'h-screen fixed left-0 z-50 w-80 bg-white border-r border-gray-300 flex flex-col transition-transform duration-300 ease-in-out',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
        isSidebarOpen ? 'top-16 lg:top-0' : 'top-0'
    ]">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <RouterLink to="/home" class="flex items-center justify-center w-full">
                <img src="../assets/logo3.webp" alt="Logo" class="h-28 mx-auto" />
            </RouterLink>
        </div>

        <!-- Sidebar Menu -->
        <SidebarLinks @link-clicked="handleLinkClick" />
    </aside>
</template>