<script setup>
import { RouterView, useRoute } from 'vue-router'
import { computed } from 'vue'

import AppLayout from '@/layouts/AppLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import LandingLayout from '@/layouts/LandingLayout.vue'

const route = useRoute()

const layout = computed(() => {
  switch (route.meta.layout) {
    case 'auth': return AuthLayout
    case 'landing': return LandingLayout
    default: return AppLayout
  }
})
</script>

<template>
  <component :is="layout">
    <RouterView />
  </component>
</template>
