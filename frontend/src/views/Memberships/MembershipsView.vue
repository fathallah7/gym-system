<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const isLoading = ref(false);
const toast = useToast();

const memberships = ref();

const fetchMemberships = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/memberships');
        console.log(response.data);
        memberships.value = response.data;
    } catch (error) {
        console.log(error);
        toast.error('Failed to fetch memberships.');
    } finally {
        isLoading.value = false;
    }
};


onMounted(() => {
    fetchMemberships();
});
</script>

<template>
    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto">
        <h1 class="flex items-center text-xl font-semibold text-gray-800">
            <i class="fa-solid fa-id-card w-6 mr-2 text-gray-600"></i>
            Memberships
        </h1>
    </header>

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">

        <!-- Search Bar -->
        <div class="mb-3 flex items-center justify-between gap-4">
            <input type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />

            <RouterLink to="/new-membership"
                class="relative bg-gray-800 text-white px-6 py-2 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
                Make Membership
            </RouterLink>
        </div>

        <Spinner v-if="isLoading" class="flex justify-center items-center" />
        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Plane</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Remaining Sessions</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">End Date</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-100 transition-colors"
                        v-for="member in memberships" :key="member.id">
                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ member.id }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.member.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.plan.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.remaining_sessions }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-block rounded-md ">
                                {{ member.end_date }}
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-gray-900 inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase"
                                :class="{ 'bg-red-100 text-red-700': member.status === 'expired', 'bg-green-100 text-green-700 ': member.status === 'active', 'bg-yellow-100 text-yellow-700': member.status === 'frozen' }">
                                {{ member.status }}</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
/* Smooth modal transitions */
.scale-100 {
    transform: scale(1);
}

.scale-0 {
    transform: scale(0.95);
}
</style>